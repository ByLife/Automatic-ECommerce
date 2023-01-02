<?php
error_reporting(E_ALL & ~E_NOTICE); // Hide all notices and warnings from PHP (for security reasons)

require 'vendor/autoload.php';

// CONFIG FILE


$config=array(
    'DB_HOST'=>'localhost', // Database Host
    'DB_USERNAME'=>'root', // Database Username
    'DB_PASSWORD'=>'', // Database Password
    'DB_DATABASE'=>'projetsql', // Database Name

    'SMTP_HOST'=>'smtp.gmail.com', // SMTP Host
    'SMTP_PORT'=>587, // SMTP Port
    'SMTP_USERNAME'=>'otp-toktokfood@toktok.ph', // SMTP Email
    'SMTP_PASSWORD'=>'qg5U!a,5', // SMTP Password

    'URL'=>'http://localhost/projet-sql/', // URL of your website

    'ADMIN_DEFAULT_EMAIL'=>'root@localhost.com', // Default Admin Email
    'ADMIN_DEFAULT_PASSWORD'=>'admin_123' // Default Admin Password
);

/* 
    You can also use this config file to connect to your database and SMTP server
    and then define them as constants so you can use them anywhere in your project
    without having to connect to the database or SMTP server again.
*/
/*

Under MIT License
Copyright (c) 2023 by ByLife

*/

try
{
    $smtp = new Project\App\SMTP\Sender($config);
    $db = new Project\App\Database\Database($config);
    $db->updateDatabase();

    define('SMTP',$smtp);
    define('DB',$db);
}
catch(PDOException $e)
{  
    die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
}

// Pourquoi le faire 2 fois ? : Check si la base de données existe, si elle n'existe pas, on la crée, puis on la charge, au cas où elle a été créée ou sa fail une fois ( 2 chances )
?>