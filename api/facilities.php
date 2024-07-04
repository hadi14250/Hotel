<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  
  <?php include('inc/links.php')?>
  <title><?php echo $settings_r['site_title']?> Facilities </title>
  </head>
 <style>
  .pop:hover{
    border-top-color:var(--teal) !important;
    transform:scale(1.03);
    transition:all 0.3s;
  }
 </style>

<body class="bg-light">
  
<?php include("inc/header.php")
?>
 
 

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">Our Facilities</h2>
  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">Lorem ipsum dolor  sit, amet consectetur adipisicing elit. Aliquam doloribus <br>
  voluptas dicta eos maiores, incidunt ipsam obcaecati provident quidem ducimus.</p>
</div>




<div class="container">
  <div class="row">
  <?php
$res = selectAll('facilities');
$path = FEATURES_IMG_PATH;

while ($row = mysqli_fetch_assoc($res)) {
    $icon = $path . $row['icon']; // Assuming 'icon' is the column name for the icon filename
    $name = $row['name']; // Assuming 'name' is the column name for the facility name
    $description = $row['description']; // Assuming 'description' is the column name for the facility description

    echo <<<data
    <div class="col-lg-4 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
                <img src="$icon" width="40px">
                <h5 class="m-0 ms-3">$name</h5>
            </div>
            <p>$description</p>
        </div>
    </div>
data;
}
?>

</div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>





<?php include("inc/footer.php");
?>

</body>
</html>
