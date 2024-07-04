<?php 
include("inc/essentials.php"); // Include essentials file
include("inc/config.php");
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features & Facilities</title>
    <?php include('inc/links.php') ?>
</head>
<body class="bg-light">
    <?php include("inc/header.php")?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Features & Facilities</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0"> Features </h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                                <i class="bi bi-plus-square"></i>  ADD
                            </button>
                        </div>
                        
                        <div class="table-responsive-md" style="height: 250px;overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                      <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data">
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



      <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="card-title m-0"> Facilities </h5>
      <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
      <i class="bi bi-plus-square"></i>  ADD
      </button>
        </div>
                        
      <div class="table-responsive-md" style="height: 350px;overflow-y:scroll;">
      <table class="table table-hover border">
          <thead >
            <tr class="bg-dark text-light">
              <th scope="col">#</th>
                <th scope="col">Icon</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                    </tr>
                  </thead>
                 <tbody id="facilities-data">
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    
  

            </div> 
        </div>
    </div>     

<!-- feature modal -->
<div class="modal fade" id="feature-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true" >
    <div class="modal-dialog">
        <form id="feature_s_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Add Feature</h5>
                </div>
                <div class="modal-body">
                    <div class=" mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="feature_name" class="form-control shadow-none" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn custom-bg text-white shadow-none" onclick="add_feature()">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <!-- facility modal  -->
    <div class="modal fade" id="facility-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true" >
   <div class="modal-dialog">
     <form id="facility_s_form">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" >Add Facility</h5>
           </div>
       <div class="modal-body">
       <div class=" mb-3">
       <label  class="form-label ">Name</label>
     <input type="text" name="facility_name"  class="form-control shadow-none" required >
     </div>
     <div class="mb-3">
       <label  class="form-label">Icon</label>
 <input type="file" name="facility_icon"  accept=".svg" class="form-control shadow-none" required>
       </div>
       
       <div class="mb-3">
      <label  class="form-label">Description</label>
  <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
  </div>
       <div class="modal-footer">
 <button type="reset" class="btn text-secondary shadow-none"  onclick="facility_s_form.reset()"
          data-bs-dismiss="modal">Cancel</button>

 <button type="button" class="btn custom-bg text-white shadow-none" onclick="add_facility()">Submit</button>

       </div> 
  </form> 
</div>
</div>
</div>  

<?php include("inc/scripts.php") ?>

<script src="scripts/features.js"></script>
</body>
</html>
