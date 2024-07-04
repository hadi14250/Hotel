  <!-- footer -->

  <div class="container-fluid bg-white mt-5">
<div class="row">
  <div class="col-lg-4 p-4">
<h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
<p>
 <?php echo $settings_r['site_about'] ?>
</p>
  </div>

  <div class="col-lg-4 p-4">
 <h5 class="mb-3">Links</h5>
 <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a> <br>
 <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a> <br>
 <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a> <br>
 <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a> <br>
 <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a> <br>
  </div>
  <div class="col-lg-4 p-4">
 <h5 class="mb-3">Follow us </h5>

 <?php
if ($contact_r['tw'] != '') {
    echo <<<data
    <a href="{$contact_r['tw']}" class="d-inline-block mb-2 text-dark text-decoration-none">
        <i class="bi bi-twitter-x me-1"></i> Twitter
    </a>
    <br>
data;
}
?>

<a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-2 text-dark text-decoration-none">
<i class="bi bi-facebook"></i>  Facebbok
</a>
<br>

<a href="<?php echo $contact_r['insta']?>" class="d-inline-block mb-2  text-dark text-decoration-none">
<i class="bi bi-instagram"></i>    Instagram
</a>
<br>
<a href="https://www.pinterest.com/" class="d-inline-block text-dark text-decoration-none">
<i class="bi bi-pinterest"></i>  Pinterest
</a>
  </div>
</div>
</div>




<h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by Mohammad Raad</h6>





<!-- footer end  -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script>




function setActive()
{

let navbar = document.getElementById('nav-bar');
let a_tags = navbar.getElementsByTagName('a');


for(i=0;i<a_tags.length;i++){

  let file = a_tags[i].href.split('/').pop();
  let file_name = file.split('.')[0];

  if(document.location.href.indexOf(file_name) >= 0){
 a_tags[i].classList.add('active');
  }
}

}

// function alert(type, msg, position = 'body') {
//     let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
//     let element = document.createElement('div');
//     element.innerHTML = `<div class="alert ${bs_class} alert-dismissible fade show" role="alert">
//       <strong class="me-3">${msg}</strong> 
//       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//     </div>`;

//     if (position == 'body') {
//         document.body.append(element);
//         element.classList.add('custom-alert');
//     } else {
//         document.getElementById(position).appendChild(element);
//     }

//     setTimeout(remAlert, 9000);
// }

let bs_class = 'alert-success';
function alert(type, msg, position = 'body') {
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `<div class="alert ${bs_class} alert-dismissible fade show" role="alert">
      <strong class="me-3">${msg}</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;

    if (position == 'body') {
        document.body.append(element);
        element.classList.add('custom-alert');
    } else {
        document.getElementById(position).appendChild(element);
    }

    setTimeout(remAlert, 9000);
}



function remAlert() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.remove();
    });
}






document.addEventListener('DOMContentLoaded', function () {
    let registerForm = document.getElementById("register-form");

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Create a FormData object to store form data
        let data = new FormData(registerForm);

        // Create an XMLHttpRequest object
        let xhr = new XMLHttpRequest();

        // Specify the request method and URL
        xhr.open("POST", "ajax/register.php", true);

        // Function to handle response from the server
        xhr.onload = function () {
            console.log("Response text:", this.responseText);

            if (this.responseText.trim() === '1') {
                alert("success", "Registration successful. Confirmation link sent to mail");
                registerForm.reset();
            } else if (this.responseText === 'pass_mismatch') {
                alert("error", "Password mismatch");
            } else if (this.responseText === 'email_already') {
                alert("error", "Email already registered");
            } else if (this.responseText === 'phone_already') {
                alert("error", "Phone number is already registered");
            } else if (this.responseText === 'inv_img') {
                alert("error", "Invalid image format. Only .jpg, .png, .jpeg are allowed");
            } else if (this.responseText === 'upd_failed') {
                alert("error", "Image upload failed");
            } else if (this.responseText === 'mail_failed') {
                alert("error", "Mail sending failed");
            } else if (this.responseText === 'ins_failed') {
                alert("error", "Registration failed! Server Down");
            } else {
                alert("error", "An error occurred during registration");
            }
        };

        // Send the request with form data
        xhr.send(data);
    });
});


//Login

document.addEventListener('DOMContentLoaded', function () {
    let loginForm = document.getElementById("login-form");

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Create a FormData object to store form data
        let data = new FormData(loginForm);

        // Create an XMLHttpRequest object
        let xhr = new XMLHttpRequest();

        // Specify the request method and URL
        xhr.open("POST", "ajax/login.php", true);

        // Function to handle response from the server
        xhr.onload = function () {
            console.log("Response from server:", this.responseText); // Debugging: log the response

            if (this.responseText === 'inv_email_mob') {
                alert("Invalid email or mobile number");
            } else if (this.responseText === 'not_verified') {
                alert("Email not verified");
            } else if (this.responseText === 'inactive') {
                alert("Account suspended! Please contact Admin");
            } else if (this.responseText === 'invalid_pass') {
                alert("Incorrect password");
            } else  {
               let fileurl = window.location.href.split('/').pop().split('?').shift();
              if(fileurl=='room_details.php'){
                window.location = window.location.href;
              }  
              else{
            window.location = window.location.pathname;
              }
            } 
        };

        // Send the request with form data
        xhr.send(data);
    });
});



     
// Forgot form :

  document.addEventListener('DOMContentLoaded', function () {
    let forgot_form = document.getElementById("forgot-form");

    forgot_form.addEventListener('submit', function (e) {
        e.preventDefault();

        let data = new FormData(forgot_form);
        let xhr = new XMLHttpRequest();

        xhr.open("POST", "ajax/forgot_password.php", true);

        xhr.onload = function () {
            console.log("Response from server:", this.responseText);

            if (this.responseText.trim() === '1') {
                alert('success',"Reset link sent to email.");
                forgot_form.reset();
            } else if (this.responseText.trim() === 'inv_email') {
                alert('error',"Invalid email address.");
            } else if (this.responseText.trim() === 'not_verified') {
                alert('error',"Email not verified! Please contact admin.");
            } else if (this.responseText.trim() === 'inactive') {
                alert('error',"Account suspended! Please contact Admin.");
            } else if (this.responseText.trim() === 'mail_failed') {
                alert('error',"Cannot send email. Server down.");
            } else if (this.responseText.trim() === 'upd_failed') {
                alert('error',"Password reset failed. Server down.");
            } else {
                alert('error',"An unexpected error occurred.");
            }
        };

        // Handle network errors
        xhr.onerror = function () {
            alert("An error occurred while processing your request.");
        };

        // Send the request with form data
        xhr.send(data);
    });
});




function checkLoginToBook(status,room_id){

  if(status){
    window.location.href='confirm_booking.php?id='+room_id;
  }
  else{
    alert('error','Please login to book room');
  }
}





setActive();


</script>