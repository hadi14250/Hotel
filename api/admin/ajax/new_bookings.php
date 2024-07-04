<?php
include("../inc/config.php");
include("../inc/essentials.php");
adminLogin();


if (isset($_POST['get_bookings'])) {
  $query = "SELECT bo.*, bd.*, IF(bo.arrival = 1, 'Yes', 'No') AS room_assigned FROM `booking_order` bo
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            WHERE bo.booking_status = 'booked'
            ORDER BY bo.booking_id ASC";

  $res = mysqli_query($con, $query);
  if (!$res) {
      die("Query failed: " . mysqli_error($con));
  }

  $i = 1;
  $table_data = "";

  if (mysqli_num_rows($res) > 0) {
      while ($data = mysqli_fetch_assoc($res)) {
          $date = date("d-m-Y", strtotime($data['datentime']));
          $checkin = date("d-m-Y", strtotime($data['check_in']));
          $checkout = date("d-m-Y", strtotime($data['check_out']));

          $table_data .= "
          <tr>
              <td>$i</td>
              <td>
                  <span class='badge bg-primary'>
                      ORDER ID: {$data['order_id']}
                  </span>
                  <br>
                  <b>Name:</b> {$data['user_name']}
                  <br>
                  <b>Phone No:</b> {$data['phonenum']}
              </td>
              <td>
                  <b>Room:</b> {$data['room_name']}
                  <br>
                  <b>Price:</b> \${$data['price']}
              </td>
              <td>
                  <b>Check in:</b> $checkin
                  <br>
                  <b>Check out:</b> $checkout
                  <br>
                  <b>Paid:</b> {$data['trans_amt']}
                  <br>
                  <b>Date:</b> $date
                  <br>
                  <b>Room Assigned:</b> {$data['room_assigned']}
              </td>
              <td>
                  <button type='button' onclick='assign_room({$data['booking_id']})' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                      <i class='bi bi-check2-square'></i>
                      Assign room
                  </button>
                  <br>
                  <button type='button' onclick='cancel_booking({$data['booking_id']})' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
                      <i class='bi bi-trash'></i>
                      Cancel Booking
                  </button>
              </td>
          </tr>";

          $i++;
      }
  } else {
      $table_data = "<tr><td colspan='5'>No bookings found.</td></tr>";
  }

  echo $table_data;
}




if (isset($_POST['assign_room'])) {
  $frm_data = filteration($_POST);

  // Check if the room is already assigned
  $check_query = "SELECT arrival FROM `booking_order` WHERE booking_id = ?";
  $check_res = select($check_query, [$frm_data['booking_id']], 'i');

  if (mysqli_num_rows($check_res) > 0) {
      $check_data = mysqli_fetch_assoc($check_res);
      if ($check_data['arrival'] == 1) {
          echo 2; // Room already assigned
          exit;
      }
  }

  $query = "UPDATE `booking_order` bo 
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            SET bo.arrival = ?, bo.rate_review=?, bd.room_no = ?
            WHERE bo.booking_id = ?";

  $values = [1,0, $frm_data['room_no'], $frm_data['booking_id']];
  $res = update($query, $values, 'iisi');

  echo ($res == 2) ? 1 : 0;
}



if(isset($_POST['cancel_booking']))
{

$frm_data = filteration($_POST);
$query = "UPDATE `booking_order` 
SET `booking_status`=? , `refund`=?  
WHERE `booking_id` = ?";

$values = ['cancelled',0,$frm_data['booking_id']];
$res = update($query,$values,'sii');

echo $res;
}








// if (isset($_POST['search'])) {
//   $search = '%' . filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING) . '%';

//   $query = "SELECT bo.*, bd.*, IF(bo.arrival = 1, 'Yes', 'No') AS room_assigned 
//             FROM `booking_order` bo
//             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
//             WHERE bo.booking_status = 'booked' 
//             AND (bo.user_name LIKE ? OR bo.phonenum LIKE ? OR bo.order_id LIKE ?)
//             ORDER BY bo.booking_id ASC";

//   $stmt = $con->prepare($query);
//   $stmt->bind_param("sss", $search, $search, $search);
//   $stmt->execute();
//   $res = $stmt->get_result();

//   $table_data = "";

//   if ($res->num_rows > 0) {
//       $i = 1;
//       while ($data = $res->fetch_assoc()) {
//           // Construct table rows as per your HTML structure
//           $table_data .= "<tr>
//                               <td>$i</td>
//                               <td>{$data['user_name']}</td>
//                               <td>{$data['room_name']}</td>
//                               <td>{$data['order_id']}</td>
//                               <td>
//                                   <button type='button' onclick='assign_room({$data['booking_id']})' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
//                                       Assign room
//                                   </button>
//                                   <button type='button' onclick='cancel_booking({$data['booking_id']})' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
//                                       Cancel Booking
//                                   </button>
//                               </td>
//                           </tr>";
//           $i++;
//       }
//   } else {
//       $table_data = "<tr><td colspan='5'>No bookings found.</td></tr>";
//   }

//   echo $table_data;
// }

?>
