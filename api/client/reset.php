<?php 
    try{
        $user = json_decode(file_get_contents('php://input'), true);

        if(!isset($user['type'])) die(json_encode(['status' => 'error', 'message' => 'Invalid request']));

        if($user['type'] == "reset_pass"){
            if(!isset($user['user_id'])) die(json_encode(['status' => 'error', 'message' => 'Invalid user id']));
            if(!isset($user['token'])) die(json_encode(['status' => 'error', 'message' => 'Invalid token']));
            if(!isset($user['user_password'])) die(json_encode(['status' => 'error', 'message' => 'Invalid password']));

            $user_id = htmlentities($user['user_id']);
            $token = htmlentities($user['token']);
            $password = htmlentities($user['user_password']);

            if(!is_numeric($user_id)) die(json_encode(['status' => 'error', 'message' => 'Invalid user id']));
            if(!is_string($token)) die(json_encode(['status' => 'error', 'message' => 'Invalid token']));
            if(!is_string($password)) die(json_encode(['status' => 'error', 'message' => 'Invalid password']));

            if(strlen($password) < 6) die(json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters long']));

            $user = DB->getUserReset($user_id, $token, $password);
            if($user === false) die(json_encode(['status' => 'error', 'message' => 'Invalid user id or token, maybe expired or unexisting']));
            die(json_encode(['status' => 'success', 'message' => 'Password reset']));


        }
        else if ($user['type'] == "reset"){
            if(!isset($user['user_email'])) die(json_encode(['status' => 'error', 'message' => 'Invalid email address']));
            $email = htmlentities($user['user_email']);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) die(json_encode(['status' => 'error', 'message' => 'Invalid email address']));

            $user = DB->getUserByEmail($email);
            if($user === false) die(json_encode(['status' => 'error', 'message' => 'Invalid email address or email already sent multiple times']));
            $token = bin2hex(random_bytes(16));
            $check = DB->insertUserReset($user['user_id'], $token, $user['email']);
            if($check === false) die(json_encode(['status' => 'error', 'message' => 'Invalid email address or email already sent multiple times']));
            SMTP
                ->setPath('reset')
                ->setUserID($user['user_id'])
                ->setToken($token)
                ->sendEmailPasswordReset($user['email']);

            die(json_encode(['status' => 'success', 'message' => 'Email sent']));
        }

        die(json_encode(['status' => 'error', 'message' => 'Invalid request']));
    } catch(Exception $e){
        die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
    }
    

    
    
?>