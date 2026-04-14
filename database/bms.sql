-- Set SQL mode and timezone
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create and use database
CREATE DATABASE IF NOT EXISTS bank_management;
USE bank_management;

-- Table: credentials (stores login details)
CREATE TABLE credentials (
  AccNo BIGINT PRIMARY KEY,
  Pass VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Table: balance (stores account balance)
CREATE TABLE balance (
  AccNo BIGINT PRIMARY KEY,
  Balance DECIMAL(15,0) DEFAULT 0,
  Interest DECIMAL(15,0) DEFAULT 0,
  FOREIGN KEY (AccNo) REFERENCES credentials(AccNo)
) ENGINE=InnoDB;

-- Table: userinfo (stores user details)
CREATE TABLE userinfo (
  AccNo BIGINT PRIMARY KEY,
  Name VARCHAR(50),
  Address VARCHAR(100),
  Email VARCHAR(64),
  Mobile VARCHAR(10) UNIQUE,
  UPI VARCHAR(50) UNIQUE,
  upi_pin VARCHAR(255),
  upi_pin_length INT,
  FOREIGN KEY (AccNo) REFERENCES credentials(AccNo)
) ENGINE=InnoDB;

-- Table: transactions (stores transaction history)
CREATE TABLE transactions (
  TxnID VARCHAR(50),
  Sender BIGINT,
  Receiver BIGINT,
  Amount DECIMAL(10,0),
  Remarks VARCHAR(50),
  DateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  SenBalance DECIMAL(15,0),
  RecBalance DECIMAL(15,0),
  Status ENUM('SUCCESS','FAILED','PENDING') DEFAULT 'PENDING',
  FOREIGN KEY (Sender) REFERENCES credentials(AccNo),
  FOREIGN KEY (Receiver) REFERENCES credentials(AccNo)
) ENGINE=InnoDB;

-- Table: audit log (stores system logs)
CREATE TABLE audit_log (
  LogID INT AUTO_INCREMENT PRIMARY KEY,
  Action VARCHAR(50),
  Description TEXT,
  CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: bill payments
CREATE TABLE bill_payments (
  BillID VARCHAR(50),
  AccNo BIGINT,
  BillType VARCHAR(50),
  Provider VARCHAR(50),
  ConsumerNo VARCHAR(50),
  Amount DECIMAL(10,2),
  Status ENUM('SUCCESS','FAILED') DEFAULT 'SUCCESS',
  CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: loans
CREATE TABLE loans (
    LoanID VARCHAR(50),
    AccNo BIGINT,
    LoanType VARCHAR(50),
    Amount DECIMAL(10,2),
    Tenure INT,
    Income DECIMAL(10,2),
    Status ENUM('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: debit cards
CREATE TABLE debit_cards (
    CardID INT AUTO_INCREMENT PRIMARY KEY,
    AccNo BIGINT,
    CardNumber VARCHAR(16) UNIQUE,
    CardHolder VARCHAR(100),
    CardType VARCHAR(20),
    Expiry DATE,
    CVV INT,
    PIN VARCHAR(255),
    Status ENUM('ACTIVE','BLOCKED') DEFAULT 'ACTIVE',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccNo) REFERENCES credentials(AccNo)
);

-- Add extra fields to debit_cards
ALTER TABLE debit_cards 
ADD DeliveryAddress TEXT,
ADD Pincode VARCHAR(10),
ADD City VARCHAR(50),
ADD State VARCHAR(50);

-- Table: credit cards
CREATE TABLE credit_cards (
    CardID INT AUTO_INCREMENT PRIMARY KEY,
    AccNo BIGINT,
    CardNumber VARCHAR(16) UNIQUE,
    CardHolder VARCHAR(100),
    CardType VARCHAR(20),
    CreditLimit DECIMAL(10,2),
    UsedLimit DECIMAL(10,2) DEFAULT 0,
    Expiry DATE,
    CVV INT,
    Status ENUM('ACTIVE','BLOCKED') DEFAULT 'ACTIVE',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccNo) REFERENCES credentials(AccNo)
);

-- Table: card transactions
CREATE TABLE card_transactions (
    TxnID VARCHAR(50),
    CardNumber VARCHAR(16),
    Amount DECIMAL(10,2),
    Type ENUM('DEBIT','CREDIT'),
    Description VARCHAR(100),
    DateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: card limits
CREATE TABLE card_limits (
    AccNo BIGINT,
    online_limit INT,
    atm_limit INT,
    pos_limit INT,
    status BOOLEAN DEFAULT TRUE
);

-- Table: card settings
CREATE TABLE card_settings (
    AccNo BIGINT PRIMARY KEY,
    online_enabled TINYINT DEFAULT 1,
    atm_enabled TINYINT DEFAULT 1,
    pos_enabled TINYINT DEFAULT 1,
    online_limit INT DEFAULT 200000,
    atm_limit INT DEFAULT 75000,
    pos_limit INT DEFAULT 200000
);

-- Add IFSC column
ALTER TABLE userinfo
ADD COLUMN IFSC VARCHAR(11);

-- Add constraints
ALTER TABLE balance
ADD CONSTRAINT chk_balance_non_negative CHECK (Balance >= 0);

ALTER TABLE transactions
ADD CONSTRAINT chk_amount_positive CHECK (Amount > 0);

-- Insert sample credentials
INSERT INTO credentials (AccNo, Pass) VALUES
(240012000001, SHA2('ram123',256)),
(240012000002, SHA2('jaja123',256)),
(240012000003, SHA2('dam123',256)),
(240012000004, SHA2('sangam123',256));

-- Insert sample balances
INSERT INTO balance (AccNo, Balance, Interest) VALUES
(240012000001, 1000, 0),
(240012000002, 500, 0),
(240012000003, 800, 0),
(240012000004, 1200, 0);

-- Insert sample users
INSERT INTO userinfo (AccNo, Name, Address, Email, Mobile, UPI) VALUES
(240012000001, 'Ram Bahadur', 'Syanjga', 'ram@bahadur.com', '9999999991', '9999999991@finova'),
(240012000002, 'Jaja Bahadur', 'Jhapa', 'haha@bahadur.com', '9999999992', '9999999992@finova'),
(240012000003, 'Dam Bahadur', 'Dhanghadi', 'dam@bahadur.com', '9999999993', '9999999993@finova'),
(240012000004, 'Sangam Adhikari', 'Pokhara', 'sangam@adhikari.com', '9999999994', '9999999994@finova');

-- Triggers
DELIMITER $$

CREATE TRIGGER trg_generate_txnid
BEFORE INSERT ON transactions
FOR EACH ROW
BEGIN
    IF NEW.TxnID IS NULL OR NEW.TxnID = '' THEN
        SET NEW.TxnID = CONCAT('TXN', DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'), FLOOR(RAND()*1000));
    END IF;
END$$

CREATE TRIGGER trg_validate_transaction
BEFORE INSERT ON transactions
FOR EACH ROW
BEGIN
    DECLARE sender_balance DECIMAL(15,0);

    SELECT Balance INTO sender_balance
    FROM balance
    WHERE AccNo = NEW.Sender;

    IF NEW.Amount <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid Amount';
    END IF;

    IF sender_balance < NEW.Amount THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insufficient Balance';
    END IF;
END$$

CREATE TRIGGER trg_transaction_full
BEFORE INSERT ON transactions
FOR EACH ROW
BEGIN
    DECLARE senderBal DECIMAL(15,0);
    DECLARE receiverBal DECIMAL(15,0);

    SELECT Balance INTO senderBal FROM balance WHERE AccNo = NEW.Sender;
    SELECT Balance INTO receiverBal FROM balance WHERE AccNo = NEW.Receiver;

    UPDATE balance SET Balance = senderBal - NEW.Amount WHERE AccNo = NEW.Sender;
    UPDATE balance SET Balance = receiverBal + NEW.Amount WHERE AccNo = NEW.Receiver;

    SET NEW.SenBalance = senderBal - NEW.Amount;
    SET NEW.RecBalance = receiverBal + NEW.Amount;
    SET NEW.Status = 'SUCCESS';
END$$

CREATE TRIGGER trg_audit_transaction
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (Action, Description)
    VALUES (
        'TRANSFER',
        CONCAT('TXN ', NEW.TxnID, ' ', NEW.Amount, ' FROM ', NEW.Sender, ' TO ', NEW.Receiver)
    );
END$$

CREATE TRIGGER trg_prevent_delete
BEFORE DELETE ON transactions
FOR EACH ROW
BEGIN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Delete not allowed';
END$$

DELIMITER ;

-- Stored Procedure for money transfer
DELIMITER $$

CREATE PROCEDURE TransferMoney(
    IN p_sender BIGINT,
    IN p_receiver BIGINT,
    IN p_amount DECIMAL(10,0),
    IN p_remarks VARCHAR(50)
)
BEGIN
    DECLARE sender_balance DECIMAL(15,0);

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT Balance INTO sender_balance
    FROM balance
    WHERE AccNo = p_sender
    FOR UPDATE;

    IF sender_balance < p_amount THEN
        ROLLBACK;
    ELSE
        INSERT INTO transactions (Sender, Receiver, Amount, Remarks)
        VALUES (p_sender, p_receiver, p_amount, p_remarks);

        COMMIT;
    END IF;

END$$

DELIMITER ;

COMMIT;