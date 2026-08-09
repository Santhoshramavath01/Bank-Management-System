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
```

---

## Requirements

Before running Finova, make sure the following software is installed:

- PHP
- MySQL
- Apache
- XAMPP / WAMP / Laragon
- Composer
- Git
- Web Browser

---

## Installation

Follow the steps below to set up and run Finova on your local machine.

### Step 1: Clone the Repository

Open a terminal or command prompt and run:

```bash
git clone https://github.com/Santhoshramavath01/Bank-Management-System.git
```

### Step 2: Navigate to the Project Directory

```bash
cd Bank-Management-System
```

### Step 3: Install a Local Server

Install one of the following local development environments:

- XAMPP
- WAMP
- Laragon

For XAMPP, make sure that Apache and MySQL are installed.

### Step 4: Move the Project to htdocs

Copy the project folder into the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\Bank-Management-System
```

### Step 5: Start Apache and MySQL

Open the XAMPP Control Panel and start:

- Apache
- MySQL

Make sure both services are running before continuing.

---

## Database Setup

### Step 1: Open phpMyAdmin

Open your browser and visit:

```text
http://localhost/phpmyadmin
```

### Step 2: Create a Database

Create a new MySQL database.

For example:

```text
finova
```

### Step 3: Import the Database

Inside phpMyAdmin:

1. Select the `finova` database.
2. Click **Import**.
3. Select the database file:

```text
database/bms.sql
```

4. Click **Import** or **Go**.

The required database tables will then be created.

---

## Database Configuration

### Configure db.php

Open the following file:

```text
configs/db.php
```

Configure the database connection according to your local MySQL
configuration.

Example:

```php
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "finova";

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
```

> Use the database configuration already required by your project.
> Do not replace your existing working configuration unnecessarily.

---

## Composer Setup

Finova uses Composer to manage PHP dependencies.

### Install Dependencies

Open a terminal inside the project directory and run:

```bash
composer install
```

This installs the dependencies specified in:

```text
composer.json
```

and creates the required Composer autoload files.

---

## Run the Application

After completing the installation and database configuration, make sure
Apache and MySQL are running.

Open your browser and visit:

```text
http://localhost/Bank-Management-System/
```

If you have renamed the project folder, replace
`Bank-Management-System` with your actual folder name.

---

## Usage

After successfully starting Finova, users can access the application
through the browser.

### New User

A new user can:

1. Open the registration page.
2. Enter the required personal information.
3. Create a banking account.
4. Log in using the registered credentials.
5. Access the Finova dashboard.
6. Use the available banking services.

### Existing User

An existing user can:

1. Open the login page.
2. Enter account credentials.
3. Authenticate successfully.
4. Access the dashboard.
5. Check balance and account information.
6. Perform banking operations.
7. View transaction history and analytics.

---

## Dashboard Services

After login, users can access the following services from the dashboard:

- Account Overview
- Balance Inquiry
- Fund Transfer
- Direct Payment
- UPI Services
- Bill Payment
- Transaction History
- Financial Analytics
- Debit Card Services
- Credit Card Services
- Loan Services
- Account Statements
- Profile Management
- Settings
- Customer Support

---

## Application Flow

The general workflow of Finova is:

```text
User
   ↓
Registration / Login
   ↓
Authentication
   ↓
Dashboard
   ↓
Banking Services
   ├── Account Management
   ├── Balance Inquiry
   ├── Fund Transfer
   ├── UPI Services
   ├── Direct Payment
   ├── Bill Payment
   ├── Transactions
   ├── Analytics
   ├── Card Services
   ├── Loan Services
   ├── Statements
   ├── Profile
   ├── Settings
   └── Customer Support
```

---

## Banking Processes

### Account Registration

Users can create a banking account through the registration page.

```text
Registration
   ↓
Enter User Information
   ↓
Validate Information
   ↓
Create Account
   ↓
Store Information in Database
   ↓
Login
```

### User Login

Users can securely log in to access their banking dashboard.

```text
Login
   ↓
Enter Credentials
   ↓
Validate Credentials
   ↓
Authentication
   ↓
Create Session
   ↓
Dashboard
```

### Balance Inquiry

Users can view their current account balance.

```text
Dashboard
   ↓
Check Balance
   ↓
Retrieve Account Information
   ↓
Display Balance
```

### Fund Transfer

Users can transfer funds between accounts.

```text
Fund Transfer
   ↓
Enter Receiver Information
   ↓
Verify Receiver
   ↓
Enter Amount
   ↓
Check Account Balance
   ↓
Process Transfer
   ↓
Update Account Balances
   ↓
Store Transaction
   ↓
Transfer Confirmation
```

### UPI Payment

Users can manage UPI-related services and make payments.

```text
UPI Services
   ├── Create UPI PIN
   ├── Change UPI PIN
   ├── Generate PIN
   ├── Find Receiver
   └── Process Payment
```

### Bill Payment

Users can make bill payments through the banking dashboard.

```text
Bill Payment
   ↓
Enter Payment Information
   ↓
Validate Information
   ↓
Process Payment
   ↓
Update Account
   ↓
Store Transaction
   ↓
Payment Confirmation
```

### Card Services

Users can manage debit and credit card services.

```text
Card Services
   ├── Apply for Debit Card
   ├── Apply for Credit Card
   ├── Manage Debit Card
   ├── Manage Credit Card
   └── Track Card Usage
```

### Loan Services

Users can access different loan-related services.

```text
Loan Services
   ├── View Loan Offers
   ├── Loan Calculator
   ├── Apply for Loan
   ├── Check Loan Status
   ├── View Loan History
   └── Loan Assistance
```

### Transaction Management

Users can view and track their banking transactions.

```text
Transactions
   ↓
Retrieve Transaction Data
   ↓
Display Transaction History
   ↓
Track Account Activity
```

### Analytics

The analytics module provides information about account and
transaction activity through visual representations.

```text
Account Data
   ↓
Transaction Data
   ↓
Process Analytics
   ↓
Generate Charts
   ↓
Display Financial Information
```

---

## PDF Statement Generation

Finova provides functionality for generating account statements.

The project uses:

- FPDF
- PDF generation functionality
- Statement templates

Relevant files include:

```text
libs/fpdf186/
scripts/statement_generator.php
configs/statement_template.php
```

Users can generate account-related statements from their banking
activities.

---

## Email Services

Finova includes email-related functionality for banking services.

The email functionality is handled through:

```text
scripts/send_email.php
```

Composer dependencies are used to support the required PHP libraries.

---

## Screenshots

Add screenshots of the Finova application to a `screenshots` folder.

Recommended structure:

```text
screenshots/
├── login.png
├── register.png
├── dashboard.png
├── analytics.png
├── transfer.png
├── transactions.png
├── cards.png
└── loans.png
```

### Login

![Login Page](screenshots/login.png)

### Registration

![Registration Page](screenshots/register.png)

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Analytics

![Analytics](screenshots/analytics.png)

### Fund Transfer

![Fund Transfer](screenshots/transfer.png)

### Transactions

![Transactions](screenshots/transactions.png)

### Card Management

![Card Management](screenshots/cards.png)

### Loan Management

![Loan Management](screenshots/loans.png)

---

## Security

Finova includes several security-related mechanisms for protecting
user accounts and banking operations:

- User authentication
- Session-based access control
- Password management
- UPI PIN management
- Account validation
- Database-backed authentication
- Controlled access to dashboard functionality

For production deployment, additional security measures should be
implemented, including:

- HTTPS
- Strong password hashing
- Two-factor authentication
- OTP verification
- CSRF protection
- Input validation
- Rate limiting
- Secure session configuration
- Encryption
- Regular security audits

---

## Future Improvements

Possible future improvements include:

- Two-factor authentication
- OTP-based transaction verification
- Email notifications
- SMS notifications
- Advanced fraud detection
- Admin dashboard
- Online payment gateway integration
- Advanced financial analytics
- Mobile application
- Cloud deployment
- Automated transaction statements
- Enhanced API security
- Improved database security
- Improved accessibility

---

## Contribution

Contributions and suggestions are welcome.

If you find a bug or want to suggest an improvement:

1. Fork the repository.
2. Create a new branch:

```bash
git checkout -b feature/your-feature
```

3. Make your changes.
4. Add the changes:

```bash
git add .
```

5. Commit the changes:

```bash
git commit -m "Add your feature"
```

6. Push the branch:

```bash
git push origin feature/your-feature
```

7. Open a Pull Request.

---

## Development

If you want to modify or extend Finova, follow these steps.

### Step 1: Clone the Repository

```bash
git clone https://github.com/Santhoshramavath01/Bank-Management-System.git
```

### Step 2: Open the Project

Open the project folder using Visual Studio Code or another code editor.

### Step 3: Configure the Database

Update the database configuration in:

```text
configs/db.php
```

### Step 4: Install Dependencies

```bash
composer install
```

### Step 5: Start the Server

Start Apache and MySQL using XAMPP, WAMP, or Laragon.

### Step 6: Open the Application

```text
http://localhost/Bank-Management-System/
```

---

## Troubleshooting

### Apache Is Not Starting

If Apache does not start:

- Check whether another application is using port 80.
- Stop conflicting services.
- Restart Apache from the XAMPP Control Panel.
- If required, change the Apache port configuration.

### MySQL Is Not Starting

If MySQL does not start:

- Check whether another MySQL service is running.
- Verify the MySQL port.
- Restart MySQL from the XAMPP Control Panel.
- Check the database configuration.

### Database Connection Error

If you receive a database connection error:

1. Make sure MySQL is running.
2. Check the database name.
3. Check the username.
4. Check the password.
5. Check the database host.
6. Verify:

```text
configs/db.php
```

### Page Not Found

Make sure the project is located inside the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\Bank-Management-System
```

Then open:

```text
http://localhost/Bank-Management-System/
```

### Composer Error

If Composer dependencies are missing, run:

```bash
composer install
```

You can check whether Composer is installed with:

```bash
composer --version
```

---

## Git Workflow

### Check Repository Status

```bash
git status
```

### Add Changes

```bash
git add .
```

### Commit Changes

```bash
git commit -m "Update Finova"
```

### Push Changes

```bash
git push
```

### Pull Latest Changes

```bash
git pull
```

---

## Author

### Ramavath Santhosh

B.Tech Computer Science Student  
Indian Institute of Information Technology Vadodara

- GitHub: https://github.com/Santhoshramavath01
- LeetCode: https://leetcode.com/u/Santhoshramavath/
- LinkedIn: https://www.linkedin.com/in/ramavath-santhosh-032436329

---

## Project Status

**Active Development**

Finova is an academic banking management project that is continuously
being improved with additional banking, payment, analytics, card, and
loan-management features.

---

## Disclaimer

Finova is an academic and software-development project intended for
learning, demonstration, and development purposes.

It is not intended to process real financial transactions or store
sensitive financial information in a production environment without
appropriate security auditing, security testing, infrastructure,
compliance, and applicable regulatory requirements.
