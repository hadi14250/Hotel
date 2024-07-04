
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php include('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> Contact </title>
</head>
<body class="bg-white">
    <?php include("inc/header.php")?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Contact Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam doloribus <br>
            voluptas dicta eos maiores, incidunt ipsam obcaecati provident quidem ducimus.</p>
    </div>



    <div class="container">
        <div class="row same-height">
            <div class="col-lg-6 col-md-6 mb-5 px-4 bg-white rounded shadow p-4">
                <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe']?>" 
                    loading="lazy" height="350px"></iframe>
                <h5>Address</h5>
                <a href="<?php echo $contact_r['gmap']?>" target="_blank" class="d-inline-block text-decoration-none mb-2">
                    <i class="bi bi-geo-alt-fill"></i>  <?php echo $contact_r['address']?>
                </a>
                <h5 class="mt-4"> Call us</h5>
                <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn1']?></a>
                <br>
    <?php

if ($contact_r['pn2'] != '') {
  echo <<<data
   <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
   <i class="bi bi-telephone-fill"></i>+$contact_r[pn2]</a>
data;
}



?>


                <h5 class="mt-4">Email</h5>
                <a href="mailto: <?php echo $contact_r['email']?>"
                    class="d-inline-block  text-decoration-none "> <i class="bi bi-envelope-at-fill"></i> 
                    <?php echo $contact_r['email']?></a>
                <h5 class="mt-4"> Follow us</h5>
                <?php
            if ($contact_r['tw'] != '') {
              echo <<<data
              <a href="$contact_r[tw]" class="d-inline-block text-dark fs-5 me-2">
                  <i class="bi bi-twitter-x me-1"></i>
              </a>
          data;
          }
          

                ?>
                
                <a href="<?php echo $contact_r['fb']?>" class="d-inline-block text-dark fs-5 me-2">
                    <i class="bi bi-facebook me-1"></i>  
                </a>
                <a href="<?php echo $contact_r['insta']?>" class="d-inline-block text-dark fs-5 me-2">
                    <i class="bi bi-instagram me-1"></i>  
                </a>
                <a href="https://www.pinterest.com/" class="d-inline-block  text-dark fs-5 ">
                    <i class="bi bi-pinterest me-1"></i> 
                </a> 
            </div> 
    

        
            
         <div class="col-lg-6 col-md-6 px-4 bg-white shadow p-4 rounded " style="height: 120vh;">
                <form method="POST">
                    <h5>Send a message</h5>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight:500;">Name</label>
                        <input name="name" required type="text" class="form-control shadow-none">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight:500;">Email</label>
                        <input name="email" required  type="email" class="form-control shadow-none">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight:500;">Subject</label>
                        <input name="subject" required type="text" class="form-control shadow-none">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight:500;">Message</label>
                        <textarea name="message" required class="form-control shadow-none" rows="5" style="resize:none;"></textarea>
                    </div> 
                    <button name="send" class="btn text-white custom-bg mt-3 " type= "submit">Send</button>
                </form>
            </div>
        </div>
    </div>  


<?php

if(isset($_POST['send'])){

$frm_data = filteration($_POST);


$q="INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
$values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];
$res = insert($q,$values,'ssss');
if($res==1){
 alert('success','Mail sent!');

}
else{
  alert('error','Server down , try again!');
}
}



?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <?php include("inc/footer.php") ?>
    <div class="custom-alert">
        <!-- Alert content -->
    </div>

</body>
</html>

