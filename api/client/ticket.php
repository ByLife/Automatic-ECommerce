<?php 

if(defined('DB')){
    $json = file_get_contents('php://input');   
    $data = json_decode($json);

    if(!isset($data->token)) die(json_encode(array("status" => "error", "message" => "Invalid request.")));

    $user = DB->getUserByToken($data->token);

    if($user === false) die(json_encode(array("status" => "error", "message" => "Invalid request.")));


    if(isset($data)){
        if(isset($data->action)){
            switch($data->action){
                case 'create_ticket':
                    if(isset($data->subject)){
                        $message = $data->subject;
                        if(strlen($message) > 5){
                            $ticket_creation = DB->createTicket($user['user_id'], $user['email'], htmlentities($message));
                            if($ticket_creation[0]){
                                echo json_encode(array('status' => 'success', 'message' => 'Ticket created', 'ticket_id' => $ticket_creation[1]));
                            } else {
                                echo json_encode(array('status' => 'error', 'message' => 'Ticket not created (Max Tickets reached)'));
                            }
                        }  else {
                            echo json_encode(array('status' => 'error' ,'message' => 'Message too short'));
                        }
                    } else {
                        echo json_encode(array('status' => 'error' , 'message' => 'Missing message'));
                    }
                    break;
                case "send_message":
                    if(isset($data->ticket_id, $data->message)){
                        if(strlen($data->message > 5)){
                            if(DB->sendTicketMessage($user['user_id'], $user['email'], $data->ticket_id, $data->message)){
                                echo json_encode(array("status" => "success", "message" => "Message sent"));
                            } else{
                                echo json_encode(array("status" => "error", "message" => "Ticket closed, not found or not sent properly"));
                            }
                        } else{
                            echo json_encode(array("status" => "error", "message" => "Message too short"));
                        }
                    } else {
                        echo json_encode(array('status' => 'Error', 'message' => 'Missing parameters'));
                    }
                    break;
                case 'get_messages':
                    if(isset($data->ticket_id)){
                        $data->ticket_id = htmlspecialchars($data->ticket_id);
                        $messages = DB->getTicketMessages($data->ticket_id);
                        if($messages !== false){
                            echo json_encode(array("status" => "success", "messages" => json_encode($messages)));
                        } else{
                            echo json_encode(array("status" => "error", "message" => "Error when getting messages"));
                        }
                    }
                    break;
                
                case 'get_owner':
                    if(isset($data->ticket_id)){
                        $data->ticket_id = htmlspecialchars($data->ticket_id);
                        $owner = DB->getTicketOwner($data->ticket_id);
                        if($owner !== false){
                            echo json_encode(array("status" => "success", "owner" => json_encode($owner)));
                        } else{
                            echo json_encode(array("status" => "error", "message" => "Error when getting owner"));
                        }
                    }
                    break;

                case 'close_ticket':
                    if(isset($data->ticket_id)){
                        $data->ticket_id = htmlspecialchars($data->ticket_id);
                        if(DB->closeTicket($data->ticket_id)){
                            echo json_encode(array("status" => "success", "message" => "Ticket closed"));
                        } else{
                            echo json_encode(array("status" => "error", "message" => "Error when closing ticket"));
                        }
                    }
                    break;

                default:
                    echo json_encode(array('status' => 'Error', 'message' => 'Action not found'));
                    break;
            }
        }
    }
}

?>