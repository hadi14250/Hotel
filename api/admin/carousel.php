<?php 
    include("inc/essentials.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel</title>
    <?php include('inc/links.php') ?>
</head>
<body class="bg-light">
    <?php include("inc/header.php")?>

<div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3">CAROUSEL</h3>

  <!-- CAROUSEL section  -->
     <div class="card" >
   <div class="card-body">
     <div class="d-flex align-items-center justify-content-between mb-3">
       <h5 class="card-title m-0"> Images</h5>
       <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
       data-bs-target="#carousel-s">
       <i class="bi bi-plus-square"></i>  ADD
      </button>
     </div>

     <div class="row" id ="carousel-data">
  

</div>
</div>
 </div> 
              
 <!-- Carousel modal -->

 <div class="modal fade" id="carousel-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true" >
   <div class="modal-dialog">
     <form id="carousel_s_form">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" >Add Image</h5>
           </div>
       <div class="modal-body">
       <div class=" mb-3">
       <label  class="form-label fw-bold">Picture</label>
 <input type="file" name="carousel_picture" id="carousel_picture_inp" accept=".jpg, .png, .jpeg" class="form-control shadow-none" required>
    </div>
    </div>
     
<div class="modal-footer">
<button type="button" class="btn text-secondary shadow-none"  onclick= "carousel_picture.value=''"
  data-bs-dismiss="modal">Cancel</button>
<button type="button" class="btn custom-bg text-white shadow-none" onclick="add_image()">Submit</button>
</div> 
</div>
  </form> 
</div>
</div>

<?php include("inc/scripts.php") ?>
<script src="scripts/carousel.js"></script>

</body>
</html>
