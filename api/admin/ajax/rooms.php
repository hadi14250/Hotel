<?php
header('Content-Type: application/json');
include("../inc/config.php");
include("../inc/essentials.php");
adminLogin();




if (isset($_POST['add_room'])) {
    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));
    $frm_data = filteration($_POST);
    $flag = 0;

    $q1 = "INSERT INTO `rooms`( `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc']];

    if (insert($q1, $values, 'siiiiis')) {
        $flag = 1;
        $room_id = mysqli_insert_id($con);

        $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
        if ($stmt = mysqli_prepare($con, $q2)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die(json_encode(["success" => false]));
        }

        $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
        if ($stmt = mysqli_prepare($con, $q3)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $flag = 0;
            die(json_encode(["success" => false]));
        }
    }

    if ($flag) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}

if(isset($_POST['get_all_rooms'])){
  $res = select("SELECT * FROM `rooms` WHERE removed=?" ,[0], 'i' );
  $i = 1;
  $data = "";

  while($row = mysqli_fetch_assoc($res)){

    if($row['status']==1){
      $status="<button onclick='toggleStatus($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>";
    }
    else{
      $status="<button onclick='toggleStatus($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";
    }

    $data .= "
      <tr class='align-middle'>
          <td>$i</td>
          <td>{$row['name']}</td>
          <td>{$row['area']} sq. ft.</td>
          <td>
              <span class='badge rounded-pill bg-light text-dark'>Adult: {$row['adult']}</span><br>
              <span class='badge rounded-pill bg-light text-dark'>Children: {$row['children']}</span>
          </td>
          <td>$ {$row['price']}</td>
          <td>{$row['quantity']}</td>
          <td>$status</td>
          <td>
            <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
              <i class='bi bi-pencil-square'></i>  
            </button>  
            <button type='button' onclick=\"room_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
            <i class='bi bi-images'></i>  
          </button>  
          <button type='button' onclick='remove_room($row[id])' class='btn btn-danger shadow-none btn-sm'>
            <i class='bi bi-trash'></i>  
          </button>  
          </td>
      </tr>";
      $i++;
  }
  echo $data;
}

if(isset($_POST['toggleStatus'])){
  $frm_data = filteration($_POST);
  $q="UPDATE `rooms` SET `status`=? WHERE `id`=?";
  $v = [$frm_data['value'],$frm_data['toggleStatus']];

  if(update($q,$v,'ii')){
    echo json_encode(["success" => true]);
  }
  else{
    echo json_encode(["success" => false]);
  }
}



if(isset($_POST['get_room'])) {
  $frm_data = filteration($_POST);
  $room_id = $frm_data['get_room'];
  
  // Fetch room details
  $res1 = select("SELECT * FROM `rooms` WHERE `id`=?", [$room_id], 'i');
  if (!$res1) {
      echo json_encode(["error" => "Failed to fetch room details: " . mysqli_error($con)]);
      exit;
  }
  
  $roomdata = mysqli_fetch_assoc($res1);

  // Fetch associated features
  $res2 = select("SELECT `features_id` FROM `room_features` WHERE `room_id`=?", [$room_id], 'i');
  if (!$res2) {
      echo json_encode(["error" => "Failed to fetch features: " . mysqli_error($con)]);
      exit;
  }
  
  $features = [];
  while ($row = mysqli_fetch_assoc($res2)) {
      $features[] = $row['features_id'];
  }

  // Fetch associated facilities
  $res3 = select("SELECT `facilities_id` FROM `room_facilities` WHERE `room_id`=?", [$room_id], 'i');
  if (!$res3) {
      echo json_encode(["error" => "Failed to fetch facilities: " . mysqli_error($con)]);
      exit;
  }

  $facilities = [];
  while ($row = mysqli_fetch_assoc($res3)) {
      $facilities[] = $row['facilities_id'];
  }

  $data = [
      "roomdata" => $roomdata,
      "features" => $features,
      "facilities" => $facilities
  ];
  
  echo json_encode($data); // Encode as JSON
  exit; // Stop further execution
}





if (isset($_POST['edit_room'])) {
  $features = filteration(json_decode($_POST['features']));
  $facilities = filteration(json_decode($_POST['facilities']));
  $frm_data = filteration($_POST);

  $q1 = "UPDATE `rooms` SET `name`= ?,`area`= ?,`price`= ?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
  $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc'], $frm_data['room_id']];

  $update_success = update($q1, $values, 'siiiiisi');

  if (!$update_success) {
      die(json_encode(["success" => false, "message" => "Failed to update room"]));
  }

  $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
  $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$frm_data['room_id']], 'i');

  if ($del_features && $del_facilities) {
      foreach ($facilities as $f) {
          $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
          if (!insert($q2, [$frm_data['room_id'], $f], 'ii')) {
              die(json_encode(["success" => false, "message" => "Failed to insert room facility"]));
          }
      }

      foreach ($features as $f) {
          $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
          if (!insert($q3, [$frm_data['room_id'], $f], 'ii')) {
              die(json_encode(["success" => false, "message" => "Failed to insert room feature"]));
          }
      }
  } else {
      die(json_encode(["success" => false, "message" => "Failed to delete room features and facilities"]));
  }

  echo json_encode(["success" => true]);

}



if(isset($_POST['add_image'])){
  // Filter and sanitize form data
  $frm_data = filteration($_POST);

  // Handle file upload
  $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);

  // Check for errors during file upload
  if ($img_r === 'inv_img' || $img_r === 'inv_size' || $img_r === 'upd_failed') {
      echo $img_r;
  } else {
      // Insert image details into the database
      $q = "INSERT INTO `room_images`(`room_id`, `image`) VALUES (?,?)";
      $values = [$frm_data['room_id'], $img_r];

      // Execute the insertion query
      $res = insert($q, $values, 'is');

      // Check if insertion was successful
      if ($res) {
        echo 'success';
    } else {
        echo 'error: Query cannot be executed - Insert'; // Output the error message
        echo '<br>Code causing the error:<br>';
        echo 'Line 773: ' . htmlentities(file_get_contents(__FILE__)) . '<br>'; // Display the code causing the error
        error_log('Insertion query failed: ' . $q); // Log the query
        error_log('Insertion values: ' . print_r($values, true)); // Log the values
    }
    
  }
}



if(isset($_POST['get_room_images'])){
  // Filter and sanitize form data
  $frm_data = filteration($_POST);
  $res = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['get_room_images']],'i');
  $path = ROOMS_IMG_PATH;


  while($row = mysqli_fetch_assoc($res))
{

  if($row['thumb']==1){
    $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";   
    }
  else{
    $thumb_btn = "<button onclick='thumb_image($row[sr_no],$row[room_id])' class='btn btn-secondary btn-sm shadow-none'>
    <i class='bi bi-check-lg'></i>
    </button>";
  }     


echo<<<data
<tr class='align-middle'>
<td><img src='$path$row[image]' class='img-fluid'></td>
<td>$thumb_btn</td>
<td>
<button onclick='rem_image($row[sr_no],$row[room_id])' class='btn btn-danger btn-sm shadow-none'>
<i class='bi bi-trash'></i>
</button>
</td>
</tr>
data;
}
  
}



if (isset($_POST['rem_image'])) {
  $frm_data = filteration($_POST);
  $values = [$frm_data['image_id'], $frm_data['room_id']];

  // Select the image from the database
  $preq = "SELECT * FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
  $res = select($preq, $values, 'ii');

  if ($row = mysqli_fetch_assoc($res)) {
      // Delete the image from the server
      if (deleteImage($row['image'], ROOMS_FOLDER)) {
          // Delete the image record from the database
          $q = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
          $res = delete($q, $values, 'ii');
          if ($res) {
              echo "success"; // Success
          } else {
              echo "error: Failed to delete from the database"; // Failed to delete from the database
          }
      } else {
          echo "error: Failed to delete from the server"; // Failed to delete from the server
      }
  } else {
      echo "error: Image not found in the database"; // Image not found in the database
  }
  exit; // Stop further execution
}




if (isset($_POST['thumb_image'])) {
$frm_data = filteration($_POST);
  
$pre_q= "UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
$pre_v= [0,$frm_data['room_id']];
$pre_res = update($pre_q,$pre_v,'ii');

$q= "UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
$v= [1,$frm_data['image_id'],$frm_data['room_id']];
$res = update($q,$v,'iii');

echo $res;

}

if(isset($_POST['remove_room']))
{

$frm_data = filteration($_POST);
$res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');

while($row = mysqli_fetch_assoc($res1)){

deleteImage($row['image'],ROOMS_FOLDER);


}

$res2 = delete("DELETE FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');
$res3 = delete("DELETE FROM `room_features` WHERE `room_id`=?",[$frm_data['room_id']],'i');
$res4 = delete("DELETE FROM `room_facilities` WHERE `room_id`=?",[$frm_data['room_id']],'i');
$res5 = delete("UPDATE `rooms`SET `removed`=?  WHERE `id`=?",[1,$frm_data['room_id']],'ii');

if($res2 || $res3 || $res4 || $res5){
echo 1;
}
else{
echo 0;
}
}

?>
