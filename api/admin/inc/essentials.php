<?php



define('SITE_URL','http://localhost/karma/hotel/');
define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
define('FEATURES_IMG_PATH', SITE_URL . 'images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL . 'images/rooms/');
define('USERS_IMG_PATH', SITE_URL . 'images/users/');



define('UPLOAD_IMG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/karma/hotel/images/');
define('FACILITIES_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/karma/hotel/images/facilities/');

define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FEATURES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');



function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        redirect('index.php');
    }
}

function redirect($url)
{
    echo "<script>window.location.href='$url';</script>";
    exit;
}

function alert($type, $msg)
{
    $bs_class = ($type == "success") ?  "alert-success" : "alert-danger";
    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
alert;
}




function deleteImage($image, $folder)
{
    $imagePath = UPLOAD_IMG_PATH . $folder . $image;

    if (file_exists($imagePath)) {
        if (unlink($imagePath)) {
            return true;
        } else {
            return false; // Failed to delete file
        }
    } else {
        return false; // File doesn't exist
    }
}

function uploadImage($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/jpeg'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif ($image['size'] / (1024 * 1024) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMG_PATH . $folder . $rname;

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}




function uploadSVGImage($image, $folder)
{
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif ($image['size'] / (1024 * 1024) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = FACILITIES_FOLDER . $rname; // Corrected path

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}






function uploadUserImage($image)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/jpeg'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".{$ext}";
        $img_path = UPLOAD_IMG_PATH . USERS_FOLDER . $rname;

        if ($ext == 'png' || $ext == 'PNG') {
            $img = imagecreatefrompng($image['tmp_name']);
        } elseif ($ext == 'jpeg' || $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG') {
            $img = imagecreatefromjpeg($image['tmp_name']);
        } else {
            return 'inv_img'; // Unsupported image type
        }

        if ($img !== false && imagejpeg($img, $img_path, 75)) {
            imagedestroy($img); // Free up memory
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}







?>