<?php
include("../inc/config.php");
include("../inc/essentials.php");
 adminLogin();




function add_image() {
  
  $img_r = uploadImage($_FILES['picture'], CAROUSEL_FOLDER);

  if ($img_r == 'inv_img') {
      echo 'inv_img';
  } elseif ($img_r == 'inv_size') {
      echo 'inv_size';
  } elseif ($img_r == 'upd_failed') {
      echo 'upd_failed';
  } else {
      $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
      $values = [$img_r];
      $res = insert($q, $values, 's');
      echo ($res) ? 'success' : 'failed';
  }
}

// Handle form submission
if(isset($_POST['add_image'])){
  add_image();
  exit; // Terminate the script after sending the response
}





if(isset($_POST['get_carousel'])){
  $res = selectAll('carousel');
  $path = CAROUSEL_IMG_PATH;

  while($row = mysqli_fetch_assoc($res)){
      echo <<<data
      <div class="col-md-4 mb-3">
          <div class="card bg-dark text-white text-end">
              <img src="{$path}{$row['image']}" class="card-img">
              <div class="card-img-overlay">
                  <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="rem_image({$row['sr_no']})">
                      <i class="bi bi-trash"></i>  Delete
                  </button>
              </div>
          </div>
      </div>
      data;
  }
}


function rem_image($id) {
  $q = "DELETE FROM `carousel` WHERE `sr_no`=?";
  $values = [$id];
  $res = delete($q, $values, 'i');

  if ($res) {
      echo 'success';
  } else {
      echo 'failed';
  }
}

if (isset($_POST['rem_image'])) {
  $id = $_POST['rem_image'];
  rem_image($id);
  exit;
}



?> 