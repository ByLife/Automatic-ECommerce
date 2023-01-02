<?php

namespace Project\App\Database;
use PDO;

require_once __DIR__ . '/db_config.php';

class Database {
    private $db_config;
    private $db;
    private $config;

    public function __construct($config){
        $this->db_config = $GLOBALS['database_config'];
        $this->config = $config;
        $this->getPDO($config);

        $this->generate();
        $this->forceInsertUser($config['ADMIN_DEFAULT_EMAIL'], $config['ADMIN_DEFAULT_PASSWORD']);
    }

    private function getPDO($config){
        try {
            $pdo = new PDO("mysql:host=" . $config['DB_HOST'] . ";port=3306;", $config['DB_USERNAME'], $config['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $config['DB_DATABASE']);
            $this->db = $pdo;
        }
        catch(PDOException $e)
        {
            die(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
        }
    }

    public function getDB(){
        return $this->db;
    }

    public function updateUserAddress($user_mail, $address_line1 = "undefined", $address_line2 = "undefined", $country = "undefined"){
        $stmt = $this->db->prepare("UPDATE " . $this->config['DB_DATABASE'] . ".users SET address_line1 = :address_line1, address_line2 = :address_line2, country = :country WHERE email = :user_mail");
        $stmt->bindParam(':user_mail', $user_mail);
        $stmt->bindParam(':address_line1', $address_line1);
        $stmt->bindParam(':address_line2', $address_line2);
        $stmt->bindParam(':country', $country);
        $stmt->execute();
    }

    private function generate(){
        foreach($this->db_config as $table => $fields){
            $this->db->exec(str_replace('DATABASE_NAME', $this->config['DB_DATABASE'], $fields));
        }
    }

    public function emailExists($user_email){
        if($this->userIsVerified($user_email)) return true;
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users WHERE email = :user_email");
        $stmt->bindParam(':user_email', $user_email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) return true;
        return false;
    }

    public function userIsVerified($user_email){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_email_verif WHERE email = :user_email");
        $stmt->bindParam(':user_email', $user_email);
        $stmt->execute();
        if($stmt->rowCount() > 2) return true;
        return false;
    }

    public function insertUserVerif($userModal){
        try{
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_email_verif (email, token, password, created_at) VALUES (:user_email, :user_token, :user_password, NOW())");
            $stmt->bindParam(':user_email', $userModal['user_email']);
            $stmt->bindParam(':user_password', $userModal['user_password']);
            $stmt->bindParam(':user_token', htmlspecialchars($_COOKIE['mail_token']));
            $stmt->execute();

            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_email_verif WHERE email = :user_email ORDER BY created_at DESC LIMIT 1");
            $stmt->bindParam(':user_email', $userModal['user_email']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];

        } catch(PDOException $e){
            return false;
        }
    }

    public function logUser($user_id){
        $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_login_activity (user_id, ip, created_at) VALUES (:user_id, :ip, NOW())");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        $stmt->execute();
    }

    public function generateRandomString($max){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $max; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getUserByEmail($user_email){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users WHERE email = :user_email");
        $stmt->bindParam(':user_email', $user_email);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserReset($id, $token, $new_password){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_password_reset WHERE user_id = :id AND token_reset = :token");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;

        $stmt = $this->db->prepare("UPDATE " . $this->config['DB_DATABASE'] . ".users SET password = :new_password WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':new_password', password_hash($new_password, PASSWORD_BCRYPT));
        $stmt->execute();

        // Delete token

        $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_password_reset WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    }

    public function getUserByToken($token){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users WHERE token = :token LIMIT 1");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserServers($user_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_servers WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserTickets($user_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created WHERE user_id = :user_id AND status = 0 ORDER BY created_at DESC");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function closeTicket($ticket_id){
        try{
            $stmt = $this->db->prepare("UPDATE " . $this->config['DB_DATABASE'] . ".users_ticket_created SET status = 1 WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function countTicket($user_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created WHERE user_id = :user_id AND status = 0");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        // Check if user exists in users
        return $stmt->rowCount();
    }

    public function createTicket($user_id, $user_email, $message){
        if($this->countTicket($user_id) > 3) return [false, null];
        
        $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_ticket_created (user_id, user_mail, ticket_id, message, created_at) VALUES (:user_id, :user_email, :ticket_id, :message, NOW())");
        $ticket_id = $this->generateRandomString(10);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        return [true, $ticket_id];
    }

    // $user['email'], $data->ticket_id, $data->message
    public function sendTicketMessage($user_id, $email, $ticket_id, $message){
        try {
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_ticket (user_id, ticket_id, user_name, message, created_at) VALUES (:user_id, :ticket_id, :user_email, :message, NOW())");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':user_email', $email);
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->bindParam(':message', $message);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getTicketOwner($ticket_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created WHERE ticket_id = :ticket_id");
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTicketMessages($ticket_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket WHERE ticket_id = :ticket_id");
        $stmt->bindParam(':ticket_id', $ticket_id);
        // Check if user exists in users
        $stmt->execute();
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersTickets(){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created ORDER BY created_at DESC");
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserLogs($user_id){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_login_activity WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 15");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTickets(){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created ORDER BY created_at DESC");
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllServers(){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_servers ORDER BY created_at DESC");
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users ORDER BY created_at DESC");
        $stmt->execute();
        // Check if user exists in users
        if($stmt->rowCount() == 0) return false;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertUserReset($user_id, $token, $email){
        try{
            // Check if user exists in users

            if($this->getUserByEmail($email) == false) return false;

            // Check if too much reset

            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_password_reset WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 2) return false;

            // Insert user

            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_password_reset (user_id, token_reset, email, created_at) VALUES (:user_id, :token, :email, NOW())");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function insertUser($id, $token){
        try{
            $stmt = "SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_email_verif WHERE id = :id AND token = :token";
            $stmt = $this->db->prepare($stmt);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            // Check if user exists in users_email_verif
            if($stmt->rowCount() == 0) return false;

            // Get email and password from users_email_verif 
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_email = $result['email'];
            $user_password = $result['password'];

            //Delete from users_email_verif
            $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_email_verif WHERE email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->execute();

            // Insert into users
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users (user_id, email, token, password, created_at) VALUES (:user_id, :user_email, :token, :user_password, NOW())");
            $stmt->bindParam(':user_id', rand(1500, strtotime(date('YmdHis'))));
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':user_password', $user_password);
            $stmt->bindParam(':token', bin2hex(random_bytes(16)));
            $stmt->execute();
            setcookie('verified', true, time() + (86400 * 30), "/");
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function forceInsertUser($email, $password){
        try{
            // Check if user exists in users
            if($this->getUserByEmail($email) != false) return false;

            // Insert into users
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users (user_id, email, token, password, created_at) VALUES (:user_id, :user_email, :token, :user_password, NOW())");
            $stmt->bindParam(':user_id', rand(1500, strtotime(date('YmdHis'))));
            $stmt->bindParam(':user_email', $email);
            $stmt->bindParam(':user_password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->bindParam(':token', bin2hex(random_bytes(16)));
            $stmt->execute();

            // Update rank to 1
            $stmt = $this->db->prepare("UPDATE " . $this->config['DB_DATABASE'] . ".users SET rank = 1 WHERE email = :user_email");
            $stmt->bindParam(':user_email', $email);
            $stmt->execute();

            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function deleteUser($user_id){
        try {
            $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function deleteServer($server_id){
        try {
            $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_servers WHERE server_id = :server_id");
            $stmt->bindParam(':server_id', $server_id);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }
    // id	name	price	description	created_at	
    // id	name	ram	cpu_core	disk_space	bandwidth	created_at	

    public function createPlan($name, $price, $ram, $cpu, $disk, $bandwith, $description){
        try {
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".plans (name, ram, cpu_core, disk_space, bandwidth ,created_at) VALUES (:name, :ram, :cpu, :disk, :band ,NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':ram', $ram);
            $stmt->bindParam(':cpu', $cpu);
            $stmt->bindParam(':disk', $disk);
            $stmt->bindParam(':band', $bandwith);
            $stmt->execute();

            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".plans_billing (name, price, description, created_at) VALUES (:name, :price, :description, NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function getPlans(){
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".plans INNER JOIN " . $this->config['DB_DATABASE'] . ".plans_billing ON " . $this->config['DB_DATABASE'] . ".plans.name = " . $this->config['DB_DATABASE'] . ".plans_billing.name");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // delete duplicated names

            $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

            return $result;
        } catch(PDOException $e){
            return false;
        }
    }

    public function getPlan($server_id){
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".plans INNER JOIN " . $this->config['DB_DATABASE'] . ".plans_billing ON " . $this->config['DB_DATABASE'] . ".plans.name = " . $this->config['DB_DATABASE'] . ".plans_billing.name WHERE " . $this->config['DB_DATABASE'] . ".plans.id = :server_id");
            $stmt->bindParam(':server_id', $server_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            return false;
        }
    }

    public function getPlanByName($name){
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".plans INNER JOIN " . $this->config['DB_DATABASE'] . ".plans_billing ON " . $this->config['DB_DATABASE'] . ".plans.name = " . $this->config['DB_DATABASE'] . ".plans_billing.name WHERE " . $this->config['DB_DATABASE'] . ".plans.name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            // Fetch 1 row
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            return false;
        }
    }

    public function createUserServer($user_id, $server_id){ // server_id = plan_id
        try {
            $plan = $this->getPlan($server_id);
            $stmt = $this->db->prepare("INSERT INTO " . $this->config['DB_DATABASE'] . ".users_servers (user_id, server_id, plan_name, hostname, root_password, created_at, end_at) VALUES (:user_id, :server_id, :plan_name, :hostname, :root_password, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))");
            $hostname = $plan['name']."-".$user_id;
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':server_id', $server_id);
            $stmt->bindParam(':plan_name', $plan['name']);
            $stmt->bindParam(':hostname', $hostname);
            $stmt->bindParam(':root_password', $this->generateRandomString(10));
            $stmt->execute();
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function getServer($server_id){
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_servers WHERE server_id = :server_id");
            $stmt->bindParam(':server_id', $server_id);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
            return false;
        } catch(PDOException $e){
            return false;
        }
    }

    public function userServerCheck($user_id, $server_id){
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_servers WHERE user_id = :user_id AND server_id = :server_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':server_id', $server_id);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            } 
            return false;
        } catch(PDOException $e){
            return false;
        }
    }

    public function updateDatabase(){
        // Delete all users that are not verified after 24 hours from table users_email_verif
        $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_email_verif WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $stmt->execute();

        // Delete all plans that are expired with the current date from the table users_servers
        $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_servers WHERE end_at < NOW()");
        $stmt->execute();        

        // Delete all users from email reset that are not verified after 24 hours from table users_password_reset
        $stmt = $this->db->prepare("DELETE FROM " . $this->config['DB_DATABASE'] . ".users_password_reset WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $stmt->execute();
    }
}

?>