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
        $stmt = $this->db->prepare("SELECT * FROM " . $this->config['DB_DATABASE'] . ".users_ticket_created WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
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