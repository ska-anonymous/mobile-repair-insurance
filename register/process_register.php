<?php

    // get business information
    $business_name = trim($_POST['b_name']);
    $business_address = trim($_POST['b_address']);
    $business_country = trim($_POST['b_country']);
    $business_city = trim($_POST['b_city']);
    $business_postal_code = trim($_POST['b_postal_code']);
    $business_email = trim($_POST['b_email']);
    $business_phone = trim($_POST['b_phone']);
    $b_type = trim($_POST['b_type']);

    $b_logo_name = '';
    if($_FILES['b_logo']['error'] === 0){
        $b_logo_name = time(). $_FILES['b_logo']['name'];
    }

    // get user information
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $user_password = trim($_POST['password']);

    // now do the data insertion

    require_once('../common/config/db_connect.php');

    if($b_type == 'insurance'){
        $sql = "INSERT INTO `insurances`(`name`, `address`, `country`, `city`, `postal_code`, `email`, `phone`, `logo`, `status`) VALUES ('$business_name','$business_address','$business_country','$business_city','$business_postal_code','$business_email','$business_phone','$b_logo_name','awaiting')";
    }else{
        $sql = "INSERT INTO `workshops`(`name`, `address`, `country`, `city`, `postal_code`, `email`, `phone`, `logo`, `status`) VALUES ('$business_name','$business_address','$business_country','$business_city','$business_postal_code','$business_email','$business_phone','$b_logo_name','awaiting')";
    }

    
    try{
        $pdo->beginTransaction();

        $stment = $pdo->prepare($sql);
        $stment->execute();
        if(!$stment->rowCount()){
            $pdo->rollBack();
            echo json_encode(['error'=>true, 'error_message'=> $stment->errorInfo()[2]]);
            exit(0);
        }
        $lastInsertId = $pdo->lastInsertId();

        // now insert user data to users table
        $pass_hash = md5($user_password);
        $sql = "INSERT INTO `users`(`name`, `email`, `phone`, `username`, `password`, `role`, `type`, `business_id`) VALUES ('$name','$email','$phone','$username','$pass_hash','admin','$b_type','$lastInsertId')";
        $stment = $pdo->prepare($sql);
        $stment->execute();
        if(!$stment->rowCount()){
            $pdo->rollBack();
            echo json_encode(['error'=>true, 'error_message'=> $stment->errorInfo()[2]]);
            exit(0);
        }

        if($_FILES['b_logo']['error'] === 0){
            move_uploaded_file($_FILES['b_logo']['tmp_name'], '../common/b_logos/'. $b_logo_name);
        }

        
        // send mail to the admin
        include('../common/phpmailer/send_mail.php');
        
        // make the url to the admin dashboard login to see the newly registered business
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $domain = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
        
        $url = $protocol . $domain . $port . '/dashboard/admin/new_registrations.php?type='.$b_type.'&id='.$lastInsertId;
            
        $subject = 'New Business Registered';
        $body = 'This is to inform you that a new '.$b_type.' registeration form has been submitted. Please review the details by clicking the link below. <br><br>
        <a href="'.$url.'">click here</a>
        ';

        // get admin email from database;
        $sql = "SELECT email from users WHERE role='super_admin'";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $pdo->commit();
        
        if($statement->rowCount()){
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $admin_email = $result['email'];
            send_mail($mail, $admin_email, $subject, $body);
        }
        
        echo json_encode(['error'=>false]);

    }catch(Exception $e){
        $pdo->rollBack();
        echo json_encode(['error'=>true, 'error_message'=> $e->getMessage()]);
    }


?>