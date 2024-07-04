<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include("../admin/inc/config.php");
include("../admin/inc/essentials.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/SMTP.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/Exception.php");
date_default_timezone_set('Asia/Beirut');

function send_mail($user_email, $token, $type) {
  $page = 'http://localhost/karma/hotel/index.php'; // Redirect to the specific URL
  $subject = $type === 'email_confirmation' ? "Account verification link" : "Account Reset link";
  $content = $type === 'email_confirmation' ? "confirm your email" : "reset your account";

  $mail = new PHPMailer\PHPMailer\PHPMailer(true);

  try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'mohamadraad515@gmail.com';
      $mail->Password = 'hexm vyev ywrc pccl';
      $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->setFrom('mohamadraad515@gmail.com', 'amira');
      $mail->addAddress($user_email);

      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = "Dear user, <br><br>Please click the following link to $content : <a href='$page?$type&email={$user_email}&token={$token}'>Click me</a>";

      $mail->send();
      return true;
  } catch (Exception $e) {
      error_log("Email sending failed: " . $e->getMessage());
      return false;
  }
}







if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $email = $data['email'] ?? '';

  $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$email], "s");

  if (mysqli_num_rows($u_exist) == 0) {
      echo 'inv_email';
  } else {
      $u_fetch = mysqli_fetch_assoc($u_exist);
      if ($u_fetch['is_verified'] == 0) {
          echo 'not_verified';
      } else if ($u_fetch['status'] == 0) {
          echo 'inactive';
      } else {
          $token = bin2hex(random_bytes(16));
          if (!send_mail($email, $token, 'account_recovery')) {
              echo 'mail_failed';
          } else {
              $date = date("Y-m-d");
              $query = mysqli_query($con, "UPDATE `user_cred` SET `token`='$token', `t_expire`='$date' WHERE `id`='{$u_fetch['id']}'");

              if ($query) {
                  echo '1';
              } else {
                  echo 'upd_failed';
              }
          }
      }
  }
} else {
  echo 'invalid_request_method';
}








?>
