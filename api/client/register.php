<?php

$userModal = array(
    "user_email" => "",
    "user_password"=> "",
    "user_password_verify"=> ""
);


$post = json_decode(file_get_contents('php://input'), true);

if(isset($post['user_email']) && isset($post['user_password']) && isset($post['user_password_verify'])){
    $userModal['user_email'] = htmlentities($post['user_email']);
    $userModal['user_password'] = htmlentities($post['user_password']);
    $userModal['user_password_verify'] = htmlentities($post['user_password_verify']);

    if($userModal['user_password'] != $userModal['user_password_verify']) die(json_encode(array("status" => "error", "message" => "Passwords do not match.")));
    if(strlen($userModal['user_password']) < 6) die(json_encode(array("status" => "error", "message" => "Password must be at least 6 characters long.")));
    if(!filter_var($userModal['user_email'], FILTER_VALIDATE_EMAIL)) die(json_encode(array("status" => "error", "message" => "Invalid email address.")));

    $userModal['user_password'] = password_hash($userModal['user_password'], PASSWORD_BCRYPT);
    if(!isset($_COOKIE['mail_token'])) die(json_encode(array("status" => "error", "message" => "Invalid token or Token not created, contact an admin.")));
    if(DB->emailExists($userModal['user_email'])) die(json_encode(array("status" => "error", "message" => "Email already exists or timed out due to spam.")));

    $user_id = DB->insertUserVerif($userModal);
    if($user_id !== false) {
        SMTP
            ->setPath("login/$user_id/")
            ->setToken($_COOKIE['mail_token'])
            ->sendEmailConfirmation($userModal['user_email']);
        die(json_encode(array("status" => "success", "message" => "Verification email sent.")));
    }
    else die(json_encode(array("status" => "error", "message" => "Something went wrong, please try again.")));
} else die(json_encode(array("status" => "error", "message" => "Invalid request.")));


?>