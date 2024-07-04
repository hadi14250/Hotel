<?php
include("../inc/config.php");
include("../inc/essentials.php");
adminLogin();

if (isset($_POST['add_feature'])) {
    add_feature();
    exit; // Terminate the script after sending the response
}

function add_feature() {
    $frm_data = filteration($_POST);

    // Adjust array key to "feature_name"
    $name = isset($frm_data['feature_name']) ? $frm_data['feature_name'] : '';

    if(empty($name)) {
        echo "0"; // Return 0 if name is empty
        exit;
    }

    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $values = [$name];
    $res = insert($q, $values, 's');

    if ($res === 1) {
        echo "1"; // Return 1 for success
    } else {
        echo "0"; // Return 0 for failure
    }
}

if(isset($_POST['get_features'])){

  $res = selectAll('features');
  $i=1;
  while($row = mysqli_fetch_assoc($res)){
      echo <<<data
      <tr>
      <td>$i</td>
      <td>$row[name]</td>
      <td>
      <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="rem_feature({$row['id']})">
      <i class="bi bi-trash"></i>  Delete
      </button>  
      </td>
      </tr>
    data;
    $i++;
  }
}



//update version with issue
// function rem_feature($id) {
//   $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?',[$id],'i');
//   if(mysqli_num_rows($check_q)==0){
//     $q = "DELETE FROM `features` WHERE `id`=?";
//     $values = [$id];
//     $res = delete($q, $values, 'i');
  
//     if ($res) {
//         echo 'success';
//     } else {
//         echo 'failed';
//     }
//   }
//   else{
//     echo 'room_added';
//   }
// }

// if (isset($_POST['rem_feature'])) {
//   $id = $_POST['rem_feature'];
//   rem_feature($id);
//   exit;
// }

function rem_feature($id) {
  $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?', [$id], 'i');
  if (mysqli_num_rows($check_q) == 0) {
      $q = "DELETE FROM `features` WHERE `id`=?";
      $values = [$id];
      $res = delete($q, $values, 'i');

      if ($res) {
          echo 'success';
      } else {
          echo 'failed';
      }
  } else {
      echo 'room_added';
  }
}

if (isset($_POST['rem_feature'])) {
  $id = $_POST['rem_feature'];
  rem_feature($id);
  exit;
}













function add_facility() {
  $frm_data = filteration($_POST);
  $img_r = uploadSVGImage($_FILES['facility_icon'], FACILITIES_FOLDER); 

  if ($img_r == 'inv_img') {
      echo 'inv_img';
  } elseif ($img_r == 'inv_size') {
      echo 'inv_size';
  } elseif ($img_r == 'upd_failed') {
      echo 'upd_failed';
  } else {
      $q = "INSERT INTO `facilities`(`icon`, `name`, `description`) VALUES (?, ?, ?)";
      $values = [$img_r, $frm_data['facility_name'], $frm_data['facility_desc']];
      $res = insert($q, $values, 'sss');
      echo ($res) ? 'success' : 'failed';
  }
}

// Handle form submission
if(isset($_POST['add_facility'])){
  add_facility();
  exit; // Terminate the script after sending the response
}



if(isset($_POST['get_facilities'])){

  $res = selectAll('facilities');
  $i=1;
  $path = FEATURES_IMG_PATH;
  while($row = mysqli_fetch_assoc($res)){
      echo <<<data
      <tr>
      <td>$i</td>
      <td><img src="$path$row[icon]" width="50px"</td>
      <td>$row[name]</td>
      <td>$row[description]</td>
      <td>
      <button class="btn btn-danger btn-sm shadow-none" type="button" onclick="rem_facility({$row['id']})">
      <i class="bi bi-trash"></i>  Delete
      </button>  
      </td>
      </tr>
    data;
    $i++;
  }
}

function rem_facility($id) {
  $q = "DELETE FROM `facilities` WHERE `id`=?";
  $values = [$id];
  $res = delete($q, $values, 'i');

  if ($res) {
      echo 'success';
  } else {
      echo 'failed';
  }
}

if (isset($_POST['rem_facility'])) {
  $id = $_POST['rem_facility'];
  rem_facility($id);
  exit;
}


?>





