<?php
include('admin/inc/config.php');
include('admin/inc/essentials.php');

if (isset($_GET['email_confirmation'])) {
    $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');

    if (mysqli_num_rows($query) == 1) {
        $fetch = mysqli_fetch_assoc($query);

        if ($fetch['is_verified'] == 1) {
            echo "<script>alert('Email already verified!')</script>";
        } else {
            $update = update("UPDATE `user_cred` SET `is_verified`=1 WHERE `id`=?", [$fetch['id']], 'i');
            if ($update) {
                echo "<script>alert('Email verification successful!')</script>";
            } else {
                echo "<script>alert('Email verification failed server down!')</script>";
            }
        }
        redirect('index.php');
    } else {
        echo "<script>alert('Invalid Link!')</script>";
        redirect('index.php');
    }
}
?>
