<?php 
    try{
        if(!is_numeric($user_id)) die(json_encode(['status' => 'error', 'message' => 'Invalid user id']));
        if(!is_string($token)) die(json_encode(['status' => 'error', 'message' => 'Invalid token']));

        echo json_encode(['status' => 'success', 'message' => 'Valid user id and token']);
    } catch(Exception $e){
        die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
    }
    

    
    
?>