<?php
// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../admin/inc/config.php");
include("../admin/inc/essentials.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/SMTP.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/Exception.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $data = filter_input_array(INPUT_POST, [
        'email_mob' => FILTER_SANITIZE_STRING,
        'pass' => FILTER_SANITIZE_STRING
    ]);

    // Fetch user credentials from the database
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], "ss");

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob'; // Invalid email/mobile number
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo 'not_verified'; // Email not verified
        } else if ($u_fetch['status'] == 0) {
            echo 'inactive'; // Account suspended
        } else {
            if (!password_verify($data['pass'], $u_fetch['password'])) {
                echo 'invalid_pass'; // Incorrect password
            } else {
                // Login successful
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo '1';
            }
        }
    }
} else {
    // Invalid request method
    echo 'invalid_request_method';
}
?>
