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
  
  get_contacts();
  get_members();
};
