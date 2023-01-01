<?php 

$post = json_decode(file_get_contents('php://input'), true);

$userModal = array(
    "user_email" => "",
    "user_password"=> ""
);

if(isset($post['user_email']) && isset($post['user_password'])){
    $userModal['user_email'] = htmlentities($post['user_email']);
    $userModal['user_password'] = htmlentities($post['user_password']);

    if(!filter_var($userModal['user_email'], FILTER_VALIDATE_EMAIL)) die(json_encode(array("status" => "error", "message" => "Invalid email address.")));
    if(strlen($userModal['user_password']) < 6) die(json_encode(array("status" => "error", "message" => "Password must be at least 6 characters long.")));

    $user = DB->getUserByEmail($userModal['user_email']);
    if($user !== false){
        if(password_verify($userModal['user_password'], $user['password'])){
            echo json_encode(array("status" => "success", "message" => "Logged in successfully.", "user" => $user));
        }
        else die(json_encode(array("status" => "error", "message" => "Invalid email address or password.")));
    }
    else die(json_encode(array("status" => "error", "message" => "Invalid email address or password.")));

} else die(json_encode(array("status" => "error", "message" => "Invalid request.")));

?>