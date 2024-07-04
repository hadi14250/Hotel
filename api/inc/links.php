<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>

  <?php
session_start();
include('admin/inc/config.php');
include('admin/inc/essentials.php');
date_default_timezone_set('Asia/Beirut');

$contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
$settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));


if ($settings_r['shutdown']) {
  echo <<<ALERTBAR
  <div class='bg-danger text-center p-2 fw-bold'>
  <i class="bi bi-exclamation-triangle-fill"></i>
      Bookings are temporarily closed!
  </div>
  ALERTBAR;
}

?>