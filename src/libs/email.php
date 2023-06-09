<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './assets/resource/PHPMailer/src/PHPMailer.php';
require './assets/resource/PHPMailer/src/SMTP.php';
require './assets/resource/PHPMailer/src/Exception.php';
require './src/config/email.php';
function send_email($receiver, $fullname, $subject, $content, $option = [])
{
    global $config;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->CharSet = "UTF-8";                  //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $config['email']['host'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $config['email']['username'];                     //SMTP username
        $mail->Password   = $config['email']['password'];                               //SMTP password
        $mail->SMTPSecure = $config['email']['SMTPSecure'];           //Enable implicit TLS encryption
        $mail->Port       = $config['email']['port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($config['email']['username'], $config['email']['fullname']);
        $mail->addAddress($receiver, $fullname);     //Add a recipient
        //        $mail->addAddress('ellen@example.com');               //Name is optional
        //        $mail->addReplyTo($config['email']['username'], $config['email']['fullname']);
        //        // $mail->addCC('cc@example.com');
        //        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
    }
}
