<?php 
include("inc/config.php");
include("inc/essentials.php");
adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bookings Records</title>
    <?php include('inc/links.php') ?>
</head>
<body class="bg-light">
    <?php include("inc/header.php")?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4"> Bookings Records</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                        <input type="text" id="searchInput" class="form-control shadow-none w-25 ms-auto" placeholder="type to search...">
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover border " style="min-width:1200px;">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Room Details</th>
                                    <th scope="col">Bookings Details</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                  
                                </tbody>
                            </table>
                        </div>
                        <nav >
           <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
         <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
       </nav>
                    </div>
                </div>

            </div> 
        </div>
    </div>     






<?php include("inc/scripts.php") ?>

<script src="scripts/booking_records.js"></script>

</body>
</html>

