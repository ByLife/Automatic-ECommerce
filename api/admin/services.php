<?php 

$post = json_decode(file_get_contents('php://input'), true);

$post = json_decode(file_get_contents('php://input'), true);
if(!isset($post['type'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

switch($post['type']){
    case "delete":
        if(!isset($post['token'], $post['server_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        if(!is_numeric($post['server_id'])) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

        $user = DB->getUserByToken($post['token']);

        if($user === false) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        if($user['rank'] == 0) die(json_encode(array("status" => "error", "message" => "Not authorised.")));

        DB->deleteServer($post['server_id']);
        echo json_encode(array("status" => "success", "message" => "Server deleted successfully."));
        break;
    case "create_plan":
        if(!isset($post['token'])) die(json_encode(array("status" => "error", "message" => "Not authorised.")));	
        if(!isset($post['name'], $post['price'])) die(json_encode(array("status" => "error", "message" => "Invalid request. 1")));
        if(!isset($post['ram'], $post['cpu_core'])) die(json_encode(array("status" => "error", "message" => "Invalid request. 2")));
        if(!isset($post['disk_space'], $post['bandwidth'])) die(json_encode(array("status" => "error", "message" => "Invalid request. 3")));
        if(!is_numeric($post['price'])) die(json_encode(array("status" => "error", "message" => "Invalid request. Price must be a number")));
        if(!is_numeric($post['ram'])) die(json_encode(array("status" => "error", "message" => "Invalid request. RAM must be a number")));
        if(!is_numeric($post['cpu_core'])) die(json_encode(array("status" => "error", "message" => "Invalid request. CPU must be a number")));
        if(!is_numeric($post['disk_space'])) die(json_encode(array("status" => "error", "message" => "Invalid request. Disk must be a number")));
        if(!is_numeric($post['bandwidth'])) die(json_encode(array("status" => "error", "message" => "Invalid request. Bandwith must be a number")));


        $user = DB->getUserByToken($post['token']);

        if($user === false) die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        if($user['rank'] == 0) die(json_encode(array("status" => "error", "message" => "Not authorised.")));

        DB->createPlan($post['name'], $post['price'], $post['ram'], $post['cpu_core'], $post['disk_space'], $post['bandwidth'] ,$post['description']);
        echo json_encode(array("status" => "success", "message" => "Plan created successfully."));
        break;
    default:
        die(json_encode(array("status" => "error", "message" => "Invalid request.")));
        break;
}

?>