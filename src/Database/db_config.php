<?php 

$GLOBALS['database_config'] =  [
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        username VARCHAR(100) DEFAULT NULL,
        password VARCHAR(1048) NOT NULL,
        email VARCHAR(100) NOT NULL,
        token VARCHAR(1048) NOT NULL,
        fullname VARCHAR(100) DEFAULT NULL,
        displayname VARCHAR(100) DEFAULT NULL,
        phonenumber VARCHAR(100) DEFAULT NULL,
        address_line1 VARCHAR(100) DEFAULT NULL,
        address_line2 VARCHAR(100) DEFAULT NULL,
        state VARCHAR(100) DEFAULT NULL,
        country VARCHAR(100) DEFAULT NULL,
        birthdate VARCHAR(500),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        rank TINYINT NOT NULL DEFAULT 0
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_login_activity (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        ip VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_email_verif (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(1048) NOT NULL,
        token VARCHAR(1048) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_password_reset (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        email VARCHAR(100) NOT NULL,
        token_reset VARCHAR(1048) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.plans (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        ram INT NOT NULL,
        cpu_core INT NOT NULL,
        disk_space INT NOT NULL,
        bandwidth INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.plans_billing (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        monthly_price VARCHAR(100) NOT NULL,
        quarterly_price VARCHAR(100) NOT NULL,
        yearly_price VARCHAR(100) NOT NULL,
        description VARCHAR(1048) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_ticket (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        user_name VARCHAR(256) NOT NULL,
        message VARCHAR(2048) NOT NULL,
        ticket_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_ticket_created (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        ticket_id INT NOT NULL,
        user_mail VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        message VARCHAR(192) NOT NULL,
        status BOOLEAN NOT NULL DEFAULT 0
    )",
    "CREATE TABLE IF NOT EXISTS DATABASE_NAME.users_servers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        server_id INT NOT NULL,
        plan_name INT NOT NULL,
        hostname VARCHAR(100) NOT NULL,
        root_password VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        end_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

];
?>