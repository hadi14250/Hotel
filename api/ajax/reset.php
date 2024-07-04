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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pass'])) {
  $data = filteration($_POST);
  $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

  $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `t_expire`=?
            WHERE `email`=? AND `token`=?";
  $values = [$enc_pass, null, null, $data['email'], $data['token']];

  if($result = update($query, $values, 'sssss')) {
      echo "Password  updated successfully";
  } else {
      echo "Failed to update password";
      // Add debug message
      error_log("Failed to update password: " . mysqli_error($conn));
  }
}

?>













