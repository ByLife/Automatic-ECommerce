<?php 

require_once './config.php'; // Load config file

if(isset($_COOKIE)){
    if(isset($_COOKIE['token'])) setcookie('token', '', time() - 3600, '/');
}

header('Location: ./');

?>