<?php
include("../inc/config.php");
include("../inc/essentials.php");
adminLogin();

if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);
    $limit = 1; // Display one record per page
    $page = intval($frm_data['page']);
    $start = ($page - 1) * $limit;

    $query = "SELECT bo.*, bd.*
              FROM `booking_order` bo
              INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
              WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
              OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
              OR (bo.booking_status = 'payment failed'))
              ORDER BY bo.booking_id DESC";

    $limit_query = $query . " LIMIT $start, $limit";

    $res = mysqli_query($con, $limit_query);
    if (!$res) {
        die("Query failed: " . mysqli_error($con));
    }

    $i = $start + 1;
    $table_data = "";

    if (mysqli_num_rows($res) > 0) {
        while ($data = mysqli_fetch_assoc($res)) {
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $status_bg = '';
            if ($data['booking_status'] == 'booked') {
                $status_bg = 'bg-success';
            } elseif ($data['booking_status'] == 'cancelled') {
                $status_bg = 'bg-danger';
            } else {
                $status_bg = 'bg-warning text-dark';
            }

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
                    <b>Amount:</b> \${$data['trans_amt']}
                    <br>
                    <b>Date:</b> $date
                </td>
                <td>
                    <span class='badge $status_bg'>{$data['booking_status']}</span>
                </td>
                <td>
                    <button type='button' onclick='download($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none'>
                    <i class='bi bi-filetype-pdf'></i>
                    </button>
                </td>
            </tr>";

            $i++;
        }

        // Pagination logic
        $total_query = "SELECT COUNT(*) AS total
                        FROM `booking_order` bo
                        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                        WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
                        OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
                        OR (bo.booking_status = 'payment failed'))";
        $total_res = mysqli_query($con, $total_query);
        $total_row = mysqli_fetch_assoc($total_res)['total'];
        $total_pages = ceil($total_row / $limit);

        $pagination = "<ul class='pagination'>";
        if ($page > 1) {
            $pagination .= "<li class='page-item'><a class='page-link' href='#' onclick='get_bookings(" . ($page - 1) . ")'>Previous</a></li>";
        }
        for ($p = 1; $p <= $total_pages; $p++) {
            $active = ($p == $page) ? "active" : "";
            $pagination .= "<li class='page-item $active'><a class='page-link' href='#' onclick='get_bookings($p)'>$p</a></li>";
        }
        if ($page < $total_pages) {
            $pagination .= "<li class='page-item'><a class='page-link' href='#' onclick='get_bookings(" . ($page + 1) . ")'>Next</a></li>";
        }
        $pagination .= "</ul>";

        echo json_encode(['table_data' => $table_data, 'pagination' => $pagination]);
    } else {
        echo json_encode(['table_data' => "<tr><td colspan='6'>No bookings found.</td></tr>", 'pagination' => '']);
    }
}







?>
