<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
//Load Composer's autoloader 
require 'PHPMailer/vendor/autoload.php';


function sendEmail($to, $name, $subject, $message) {
    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        //$mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.honestate.co.ke';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'accounts@honestate.co.ke';                     //SMTP username
        $mail->Password   = 'N%cJH-if%tV9';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('accounts@honestate.co.ke', 'Honestate');
        $mail->addAddress($to, $name);     //Add a recipient
        $mail->addReplyTo('accounts@honestate.co.ke', 'Honestate');
        $mail->addBCC('honestate21@gmail.com');

        //Attachments        //Add attachments
        //$mail->addAttachment('KCW200J.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

/*sendEmail('mogsharry@gmail.com', 'Harrison', 'Good afternoon!\n
Thank you for creating an account with us');*/
ob_end_flush();

?>