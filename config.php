<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'vendor/autoload.php';

// DATABASE
$config=array(
    'DB_HOST'=>'localhost',
    'DB_USERNAME'=>'root',
    'DB_PASSWORD'=>'',
    'DB_DATABASE'=>'projetsql',

    'SMTP_HOST'=>'smtp.gmail.com',
    'SMTP_PORT'=>587,
    'SMTP_USERNAME'=>'otp-toktokfood@toktok.ph',
    'SMTP_PASSWORD'=>'qg5U!a,5',

    'URL'=>'http://localhost/projet-sql/'
);

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