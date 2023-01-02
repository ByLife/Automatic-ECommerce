<?php 

$post = json_decode(file_get_contents('php://input'), true);

if(!isset($post['token'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
if(!isset($post['type'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

$user = DB->getUserByToken($post['token']);

if($user === false) die(json_encode(array("status" => "error", "message" => "Invalid request. 1")));

switch($post['type']){
    case "place":
        if(!isset($post['product_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        if(!is_numeric($post['product_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

        DB->createUserServer($user['user_id'], $post['product_id']);
        echo json_encode(array("status" => "success", "message" => "Order placed successfully."));
        break;
    default:
        die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        break;
}

?>