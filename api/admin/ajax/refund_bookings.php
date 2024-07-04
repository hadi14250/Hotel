<?php
include("../inc/config.php");
include("../inc/essentials.php");
adminLogin();


if (isset($_POST['get_bookings'])) {
  $query = "SELECT bo.*, bd.*
            FROM `booking_order` bo
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            WHERE bo.booking_status = 'cancelled' AND bo.refund=0
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
                  <br>
                  <b>Check out:</b> $checkout
                  <br>
                  <b>Check in:</b> $checkin
                  <br>
                  <b>Date:</b> $date
              </td>
              <td>
                <br>
                <b>Paid:$</b> {$data['trans_amt']}
                <br>
              </td>
              <td>
               <button type='button' onclick='refund_booking({$data['booking_id']})' class=' btn btn-success btn-sm fw-bold shadow-none'>
                <i class='bi bi-cash-stack'></i>
                      Refund
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






if(isset($_POST['refund_booking']))
{

$frm_data = filteration($_POST);

$query = "UPDATE `booking_order` 
SET `refund`=?  
WHERE `booking_id` = ?";

$values = [1,$frm_data['booking_id']];
$res = update($query,$values,'ii');

echo $res;
}




?>
