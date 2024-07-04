<?php
session_start();

include("../admin/inc/config.php");
include("../admin/inc/essentials.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/SMTP.php");
require("../inc/PHPMailer-master/PHPMailer-master/src/Exception.php");

function send_mail($user_email, $name, $token) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mohamadraad515@gmail.com';  // Your Gmail address
        $mail->Password   = 'hexm vyev ywrc pccl';  // Your app-specific password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom('mohamadraad515@gmail.com', 'amira'); // Your Gmail address and sender name

        // Recipients
        $mail->addAddress($user_email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Email';
        $mail->Body = "Dear $name, <br><br>Please click the following link to verify your email: <a href='http://localhost/karma/hotel/email_confirm.php?email_confirmation&email={$user_email}&token={$token}'>Verify Email</a>";


        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log or display the error
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $data = filter_input_array(INPUT_POST, [
        'name' => FILTER_SANITIZE_STRING,
        'email' => FILTER_VALIDATE_EMAIL,
        'address' => FILTER_SANITIZE_STRING,
        'phonenum' => FILTER_SANITIZE_STRING,
        'pincode' => FILTER_VALIDATE_INT,
        'dob' => FILTER_SANITIZE_STRING,
        'pass' => FILTER_SANITIZE_STRING,
        'cpass' => FILTER_SANITIZE_STRING
    ]);

    // Check if passwords match
    if ($data['pass'] != $data['cpass']) {
        echo 'pass_mismatch';
        exit;
    }

    // Check if email or phone number already exists
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email'], $data['phonenum']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // Upload user image
    $img = uploadUserImage($_FILES['profile']);
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    // Generate token and send verification email
    $token = bin2hex(random_bytes(16));
    if (!send_mail($data['email'], $data['name'], $token)) {
        echo 'mail_failed';
        exit;
    }

    // Encrypt password
    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    // Insert user into the database
    $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `token`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['dob'], $img, $enc_pass, $token];

    if (insert($query, $values, 'sssssssss')) {
        echo '1';
    } else {
        echo 'ins_failed';
    }
} else {
    // Invalid request method
    echo 'invalid_request_method';
}
?>
