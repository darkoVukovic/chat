<?php namespace App\Libraries;

require_once('../../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class MY_Mailer {

    protected $mail;

    public function __constructor () {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'user@example.com';                     //SMTP username
        $this->mail->Password   = 'secret';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    } 



    public function setFrom() {
        $this->mail->setFrom('darko.praska@gmail.com', 'Mailer');
        $this->mail->addAddress('daredareize@gmail.com', 'Joe User');     //Add a recipient
    }
    
    public function send () {

        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Here is the subject';
        $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        try {
            $this->mail->send();
        }
        catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    } 

}