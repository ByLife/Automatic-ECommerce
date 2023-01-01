<?php
namespace Project\App\SMTP;

require_once './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class Sender {
    private $config;
    private $user_id;
    private $token;
    private $path;

    public function __construct($config){
        $this->config = $config;
        $this->config['URL'] = $config['URL'];
    }

    private function prepareMail(){
        $mail = new PHPMailer();

        $mail->isSMTP();
    
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
    
        $mail->Host = $this->config['SMTP_HOST'];
        $mail->Port =  $this->config['SMTP_PORT'];
        $mail->SMTPAuth = true;
    
        $mail->Username = $this->config['SMTP_USERNAME'];
        $mail->Password = $this->config['SMTP_PASSWORD'];
        return $mail;
    }

    public function setPath($path){
        $this->path = $this->config['URL'].$path;
        return $this;
    }

    public function setUserID($user_id){
        $this->user_id = $user_id;
        return $this;
    }

    public function setToken($token){
        $this->token = $token;
        return $this;
    }

    private function sendEmail($email, $object, $subject, $body){
        $mail = $this->prepareMail();
        $mail->setFrom($this->config['SMTP_USERNAME'], $object);
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->msgHTML($body);
        $mail->send();
    }

    public function sendEmailConfirmation($email){
        $content = file_get_contents('./src/SMTP/templates/mail_register.html');
        $content = str_replace('{TOKEN}', $this->token, $content);
        $content = str_replace('{URL}', $this->path, $content);
        $this->sendEmail($email, 'Cursa', 'Confirmation de votre compte', $content);
    }

    public function sendEmailPasswordReset($email){
        $content = file_get_contents('./src/SMTP/templates/mail_reset.html');
        $content = str_replace('{TOKEN}', $this->token, $content);
        $content = str_replace('{USER_ID}', $this->user_id, $content);
        $content = str_replace('{URL}', $this->path, $content);
        $this->sendEmail($email, 'Cursa', 'Réinitialisation de votre mot de passe', $content);
    }
}
?>