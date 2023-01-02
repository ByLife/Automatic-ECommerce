<?php 

$post = json_decode(file_get_contents('php://input'), true);

$post = json_decode(file_get_contents('php://input'), true);

if(!isset($post['token'], $post['user_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
if(!is_numeric($post['user_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
if(!isset($post['type'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

$user = DB->getUserByToken($post['token']);

if($user === false) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
if($user['rank'] == 0) die(json_encode(array("status" => "error", "message" => "Not authorised.")));

switch($post['type']){
    case "delete":
        DB->deleteUser($post['user_id']);
        echo json_encode(array("status" => "success", "message" => "User deleted successfully."));
        break;
    default:
        die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        break;
}
?>