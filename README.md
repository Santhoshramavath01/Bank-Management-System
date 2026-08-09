# Finova - Bank Management System

Finova is a web-based banking management system designed to provide
users with a convenient and secure platform for managing their banking
activities.

The system provides features such as account management, balance
inquiry, fund transfers, UPI services, bill payments, card management,
loan services, transaction tracking, analytics, and profile management.

---

## Features

### Account Management

- User registration and login
- Secure account authentication
- Account profile management
- Balance inquiry
- Change password
- Mobile number update
- Profile image upload
- Account information management

### Payments & Transfers

- Fund transfers between accounts
- Direct payments
- UPI receiver management
- UPI PIN creation and management
- UPI PIN change
- Bill payment
- Payment status tracking
- Transfer success confirmation

### Transaction Management

- Transaction history
- Transaction details
- Account activity tracking
- Transaction analytics
- Interest calculation
- Interest-related account information

### Card Services

- Debit card management
- Credit card management
- Card application
- Card usage tracking
- Debit card processing
- Credit card processing

### Loan Services

- Loan application
- Loan calculator
- Loan offers
- Loan status tracking
- Loan history
- Loan assistance
- Loan management

### Additional Services

- Financial analytics
- Account statements
- PDF statement generation
- Email services
- Customer support
- User settings
- Responsive dashboard

---

## Technologies Used

### Frontend

- HTML5
- CSS3
- JavaScript
- Bootstrap

### Backend

- PHP

### Database

- MySQL
- SQL

### Libraries & Tools

- Composer
- FPDF
- DOMPDF
- PHPMailer
- Git
- GitHub

---

## Project Structure

```text
Finova/
│
├── assets/
│
├── configs/
│   ├── db.php
│   └── statement_template.php
│
├── database/
│   └── bms.sql
│
├── libs/
│   └── fpdf186/
│
├── pages/
│   ├── dashboard/
│   │   ├── analytics.php
│   │   ├── apply_credit.php
│   │   ├── apply_debit.php
│   │   ├── bill_pay.php
│   │   ├── card_summary.php
│   │   ├── card_usage.php
│   │   ├── change_password.php
│   │   ├── change_upi_pin.php
│   │   ├── check_balance.php
│   │   ├── create_upi_pin.php
│   │   ├── debit_card.php
│   │   ├── direct_pay.php
│   │   ├── loan_apply.php
│   │   ├── loan_calculator.php
│   │   ├── loan_history.php
│   │   ├── loan_offers.php
│   │   ├── loan_status.php
│   │   ├── loans.php
│   │   ├── manage_credit.php
│   │   ├── manage_debit.php
│   │   ├── profile.php
│   │   ├── settings.php
│   │   ├── support.php
│   │   ├── transactions.php
│   │   ├── transfer.php
│   │   └── update_mobile.php
│   │
│   ├── home.php
│   ├── login.php
│   └── register.php
│
├── scripts/
│   ├── apply_credit_process.php
│   ├── apply_debit_process.php
│   ├── bal_transfer.php
│   ├── bill_pay_process.php
│   ├── change_accinfo.php
│   ├── change_upi_pin_process.php
│   ├── direct_pay_process.php
│   ├── get_analytics.php
│   ├── get_balance.php
│   ├── get_interest.php
│   ├── get_receiver.php
│   ├── get_transactions.php
│   ├── get_upi_receiver.php
│   ├── get_userinfo.php
│   ├── interest_increase.php
│   ├── loan_apply_process.php
│   ├── login_auth.php
│   ├── logout.php
│   ├── register_auth.php
│   ├── send_email.php
│   ├── statement_generator.php
│   ├── update_card_usage.php
│   ├── update_mobile_process.php
│   └── upload_img.php
│
├── vendor/
│
├── .gitignore
├── composer.json
├── composer.lock
├── index.php
└── README.md


Installation
1. Clone the Repository
git clone https://github.com/Santhoshramavath01/Bank-Management-System.git
2. Navigate to the Project
cd Bank-Management-System
3. Install a Local Server

Install any local PHP development environment such as:

XAMPP
WAMP
Laragon
4. Move the Project

If you are using XAMPP, move the project folder into:

C:\xampp\htdocs\

The project should be located at:

C:\xampp\htdocs\Bank-Management-System\
5. Start Apache and MySQL

Open XAMPP Control Panel and start:

Apache
MySQL

6. Create the Database

Open:

http://localhost/phpmyadmin

Create a new database and import:

database/bms.sql
7. Configure the Database

Open:

configs/db.php

Update the database credentials according to your local MySQL setup.

Example:

$host = "localhost";
$username = "root";
$password = "";
$database = "your_database_name";
8. Install Composer Dependencies

If Composer is installed, run:

composer install
9. Run the Application

Open your browser and visit:

http://localhost/Bank-Management-System/
Database

Finova uses a MySQL relational database.

The database file is located at:

database/bms.sql

The database manages information related to:

Users
Bank accounts
Transactions
Fund transfers
Cards
Loans
Payments
UPI services
Account information
PDF Statement Generation

Finova supports account statement generation.

The project includes:

libs/fpdf186/

and:

scripts/statement_generator.php

These components are used to generate PDF account statements.

Dashboard

After successful login, users can access the Finova dashboard.

The dashboard provides access to:

Account balance
Analytics
Transactions
Fund transfers
Bill payments
Card services
Loan services
UPI services
Profile management
Settings
Customer support
