<?php
     //import php mailer classes and do other configs to send mails to clients 
     use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\Exception;
 
     require('src/PHPMailer.php');
     require('src/SMTP.php');
     require('src/Exception.php');

     $mail = new PHPMailer(true);

     // SMTP configuration
     $mail->isSMTP();
     $mail->Host = 'smtp.hostinger.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'success@thecareerdesigner.com';
     $mail->Password = 'Reet@1708';
     $mail->SMTPSecure = 'ssl';
     $mail->Port = 465;
     $mail->isHTML(true);

     $mail->setFrom('success@thecareerdesigner.com', 'Admin Creer Designer');
     // clear all recipients to avoid email sent multiple times to the same user

    function send_mail($mail, $to, $subject, $body){
        $mail->ClearAllRecipients();
        $mail->ClearAddresses();

        $mail->addAddress($to);
        $mail->Subject = $subject;

        $mail->Body = $body;

        try{
            $mail->send();
            return ['error'=> false];
        }catch(Exception $e){
            return ['error'=> true, 'error-message' => $e->getMessage()];
        }
    }
    
?>