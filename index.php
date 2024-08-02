<?php
    session_start();
    // check if user is not logged in redirect to login and if logged in then redirect to its relevant dashboard
    if(!$_SESSION['logged']){
        header('location:login');
    }else{
        $user_role = $_SESSION['user']['role'];
        $user_type = $_SESSION['user']['type'];
        if($user_role == 'super_admin'){
            header('location:admin');
            exit(0);
        }elseif($user_role == 'admin' && $user_type == 'insurance'){
            header('location:insurance/admin');
            exit(0);
        }elseif($user_role == 'admin' && $user_type == 'workshop'){
            header('location:workshop/admin');
            exit(0);
        }
    }
?>