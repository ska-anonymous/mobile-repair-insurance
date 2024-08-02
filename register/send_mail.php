<?php
    // send mail to the admin
    include('../common/phpmailer/send_mail.php');

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $domain = $_SERVER['HTTP_HOST'];
    $port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
    
    $url = $protocol . $domain . $port . '/dashboard/admin/new_registrations.php?type=workshop&id=5';
        
    $subject = 'New Business Registered';
    $body = 'This is to inform you that a new workshop registeration form has been submitted. Please review the details by clicking the link below. <br><br>
    <a href="'.$url.'">'.$url.'</a>
    ';
    send_mail($mail, 'salmankhanserai@gmail.com', $subject, $body);
?>