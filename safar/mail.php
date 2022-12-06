<?php

    if (isset($_POST['btnAdd'])) {
        $name = $_POST['name']; print_r($name);
        $message1 = $_POST['message']; print_r($message1);
        $mobile = $_POST['mobile']; print_r($mobile);
        $email = $_POST['email']; print_r($email);
        $time = $_POST['time']; print_r($time);
        
        $to      = 'hiteshr.patil1@gmail.com';
        $subject = 'the subject';
        $message = 'Name :' . '' . $name . '' . ', ';
        $message .= 'Message :' . '' . $message1 . '' . ', ';
        $message .= 'Mobile No. : ' . '"' . $mobile . '"';
        $message .= 'Suitable Time To Talk : ' . '"' . $time . '"';
        $headers = 'From: ' . $email . ''       . "\r\n" .
            'Reply-To: ' . $email . '' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message, $headers)){
            echo '<script>alert("Mail Send Successfully");window.location.href="index.php";</script>';
        }else{
            echo '<script>alert("");window.location.href="index.php";</script>';
        }
    }

    if (isset($_POST['send'])) {
        $name = $_POST['name'];
        $message1 = $_POST['message'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $time = $_POST['time'];
        
        $to      = 'hiteshr.patil1@gmail.com';
        $subject = 'the subject';
        $message = 'Name :' . '' . $name . '' . ', ';
        $message .= 'Message :' . '' . $message1 . '' . ', ';
        $message .= 'Mobile No. : ' . '"' . $mobile . '"';
        $message .= 'Suitable Time To Talk : ' . '"' . $time . '"';
        $headers = 'From: ' . $email . ''       . "\r\n" .
            'Reply-To: ' . $email . '' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message, $headers)){
            echo '<script>alert("Mail Send Successfully");window.location.href="index.php";</script>';
        }else{
            echo '<script>alert("");window.location.href="index.php";</script>';
        }
    }
?>