<?php 
    include("inc/essentials.php");
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <?php include('inc/links.php') ?>
</head>
<body class="bg-light">
    <?php include("inc/header.php")?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-3">SETTINGS</h3>

                <!-- General settings -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square"></i> EDIT
                            </button>
                        </div>

                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text" id="site_about"></p>
                    </div>
                </div>

                <!-- General settings modal -->
                <div class="modal fade" id="general-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">About us</label>
                                        <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" onclick="cancelGeneralUpdate()" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn custom-bg text-white shadow-none" onclick="upd_general(site_title.value,site_about.value)">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

              <!-- Shut down -->
              
                 <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown   Website</h5>
                            <div class="form-check form-switch">
                        <form >
                      <input  onchange="upd_shutdown(this.checked)" class="form-check-input" type="checkbox" id="shutdown-toggle" > 
                        </form>
                      </div>
                      </div>
                     <p class="card-text" >
                  No customers will be allowed to book hotel room,when shutdown mode is turned on    
                </p>
                </div>
                </div>  

          <!-- Contact settings -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contacts Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
                                <i class="bi bi-pencil-square"></i> EDIT
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone numbers</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text ">
                                        <i class="bi bi-instagram me-1"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text ">
                                        <i class="bi bi-twitter-x me-1"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iframe</h6>
                                    <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact settings modal -->
                <div class="modal fade" id="contacts-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true">
                    <div class="modal-dialog modal-lg">
                        <form id="contacts_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contacts Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Address</label>
                                                    <input type="text" name="address" id="address_inp" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Google Map Link</label>
                                                    <input type="text" name="gmap" id="gmap_inp" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Phone Numbers (with country code)</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="number" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="number" name="pn2" id="pn2_inp" class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Email</label>
                                                    <input type="email" name="email" id="email_inp" class="form-control shadow-none" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Social Links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                                        <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                                        <input type="text" name="insta" id="insta_inp" class="form-control shadow-none">
                                                    </div>

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-twitter-x me-1"></i></span>
                                                        <input type="text" name="tw" id="tw_inp" class="form-control shadow-none">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">iframe SRC</label>
                                                    <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" onclick="cancelContactsUpdate()" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn custom-bg text-white shadow-none" onclick="upd_contacts()">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Contact settings end -->

                <!-- Additional sections can be added here -->
                   
  <!-- Management team section  -->
     <div class="card" >
   <div class="card-body">
     <div class="d-flex align-items-center justify-content-between mb-3">
       <h5 class="card-title m-0"> Management Team </h5>
       <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
       data-bs-target="#team-s">
       <i class="bi bi-plus-square"></i>  ADD
      </button>
     </div>

     <div class="row" id ="team-data">
  

</div>
</div>
 </div> 
              
 <!-- Management team modal -->

 <div class="modal fade" id="team-s" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true" >
   <div class="modal-dialog">
     <form id="team_s_form">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" >Add team member</h5>
           </div>
       <div class="modal-body">
       <div class=" mb-3">
       <label  class="form-label ">Name</label>
     <input type="text" name="member_name" id="member_name_inp" class="form-control shadow-none" required >
     </div>
     <div class="mb-3">
       <label  class="form-label">Picture</label>
 <input type="file" name="member_picture" id="member_picture_inp" accept=".jpg, .png, .jpeg" class="form-control shadow-none" required>
       </div>
       </div>
       <div class="modal-footer">
 <button type="button" class="btn text-secondary shadow-none"  onclick= ""
          data-bs-dismiss="modal">Cancel</button>

 <button type="button" class="btn custom-bg text-white shadow-none" onclick="add_member()">Submit</button>

       </div> 
  </form> 
</div>
</div>
</div>  

 <!-- this is my management team -->





<?php include("inc/scripts.php") ?>


<script>
let general_data, contacts_data;

let site_title = document.getElementById('site_title');
let site_about = document.getElementById('site_about');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');
let contacts_s_form = document.getElementById('contacts_s_form');
let general_s_form = document.getElementById('general_s_form');
let team_s_form = document.getElementById('team_s_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');
let shutdown_toggle = document.getElementById('shutdown-toggle');

function get_general() {
let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      general_data = JSON.parse(this.responseText);
      site_title.innerText = general_data.site_title;
      site_about.innerText = general_data.site_about;
      site_title_inp.value = general_data.site_title;
      site_about_inp.value = general_data.site_about;

      if (general_data.shutdown == 0) {
        shutdown_toggle.checked = false;
        shutdown_toggle.value = 0;
      } else {
        shutdown_toggle.checked = true;
        shutdown_toggle.value = 1;
      }
    

  };
  xhr.send('get_general');
}




function upd_general(site_title_val, site_about_val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      if (this.responseText == 1) {
          alert('Success', 'Changes Done!');
          get_general();
      } else {
          alert('Error', 'No Changes made!');
      }
  }
  xhr.send('site_title=' + encodeURIComponent(site_title_val) + '&site_about=' + encodeURIComponent(site_about_val) + '&upd_general');
}



document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('shutdown-toggle').checked = false;
});

function upd_shutdown(isShutdown) {
    let shutdownValue = isShutdown ? 1 : 0;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText.trim() === "1") {
            let alertType = isShutdown ? 'success' : 'danger';
            let message = 'Shutdown mode ' + (isShutdown ? 'on' : 'off') + '!';
            alert(alertType, message);

            // Check if the current page is the admin page
            if (!window.location.href.includes("admin")) {
                // Redirect to index page for regular users
                window.location.href = "../index.php";
            }
        } else {
            alert('danger', 'Failed to update shutdown mode!');
        }
    };
    xhr.send('shutdown=' + shutdownValue);
}


function get_contacts() {
  let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
  let iframe = document.getElementById('iframe');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      contacts_data = JSON.parse(this.responseText);
      contacts_data = Object.values(contacts_data);

      for (let i = 0; i < contacts_p_id.length; i++) {
          document.getElementById(contacts_p_id[i]).innerText = contacts_data[i + 1];
      }
      iframe.src = contacts_data[9];
  }
  xhr.send('get_contacts');
}

function contacts_inp(data) {
  let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
  for (let i = 0; i < contacts_inp_id.length; i++) {
      document.getElementById(contacts_inp_id[i]).value = data[i + 1];
  }
}

contacts_s_form.addEventListener('submit', function (e) {
  e.preventDefault();
  upd_contacts();
});

function upd_contacts() {
  let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw', 'iframe'];
  let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
  let data_str = "";

  for (let i = 0; i < index.length; i++) {
      data_str += index[i] + "=" + encodeURIComponent(document.getElementById(contacts_inp_id[i]).value) + '&';
  }

  data_str += "upd_contacts";

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (this.responseText == 1) {
          alert('Success', 'Changes saved!');
          get_contacts();
      } else {
          alert('error', 'No changes made!');
      }
  }
  xhr.send(data_str);
}

team_s_form.addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent the default form submission
  add_member(); // Call the add_member function to handle form submission
});


function add_member() {
  let data = new FormData();
  data.append('name', member_name_inp.value);
  data.append('picture', member_picture_inp.files[0]);
  data.append('add_member', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);

  xhr.onload = function () {
      if (this.responseText === 'inv_img') {
          alert('error', 'Invalid image format. Only PNG, JPG, or JPEG files are allowed.');
      } else if (this.responseText === 'inv_size') {
          alert('error', 'Image size should be less than 2MB.');
      } else if (this.responseText === 'upd_failed') {
          alert('error', 'Failed to upload image. Please try again later.');
      } else if (this.responseText === 'success') {
          alert('success', 'New member added successfully!');
          member_name_inp.value = '';
          member_picture_inp.value = '';
          get_members(); // Refresh the team members after adding a new member
      } else {
          alert('error', 'Unexpected response from server: ' + this.responseText);
      }
  };

  xhr.send(data);
}

function get_members() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      document.getElementById('team-data').innerHTML = this.responseText;
  }
  xhr.send('get_members');
}

function rem_member(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/settings_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      if (this.responseText.trim() === 'success') {
          alert('success', 'Member removed!');
          get_members(); // Refresh the team members after successful removal
      } else if (this.responseText.trim() === 'failed') {
          alert('error', 'Failed to remove member. Server might be down or an error occurred.');
      } else {
          alert('error', 'Unexpected response from server: ' + this.responseText);
      }
  };
  xhr.onerror = function () {
      alert('error', 'Failed to connect to the server.');
  };
  xhr.send('rem_member=' + id);
}

window.onload = function () {
  get_general();
  get_contacts();
  get_members();
};
</script>



  </div>
  </div>
  </div>
</body>
</html>
