# PHP OOP CRUD Project

This PHP project is an example of a simple CRUD (Create, Read, Update, Delete) application using Object-Oriented Programming (OOP) principles. It also includes user authentication features like login and signup. The project uses MySQL for database storage and Ajax for real-time email availability checks during signup.


## Features

**CRUD Operations:** Perform Create, Read, Update, and Delete operations on a MySQL database.

**User Authentication:** Secure login and signup features for user authentication.

**Form Validation:** Handle form errors and provide feedback to users.

**AJAX Email Check:** Use AJAX to asynchronously check if an email is already registered during signup.



## Database Schema

### `data` Table

CREATE TABLE IF NOT EXISTS data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    name VARCHAR(255) NOT NULL,
    
    score INT NOT NULL
);


### `login` Table

CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    email VARCHAR(255) NOT NULL,
    
    name VARCHAR(255) NOT NULL,
    
    password VARCHAR(255) NOT NULL,
    
    mobile VARCHAR(20)
);


### Configure the database connection in db.php:

// db.php

private $hostname = 'your-database-hostname';

private $username = 'your-database-username';

private $password = 'your-database-password';

private $database = 'your-database-name';



## Usage

Visit index.php to perform CRUD operations.

Access login_form.php for user login.

Navigate to signup_form.php to create a new account.

