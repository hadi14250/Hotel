let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');


  function add_feature() {
      let feature_s_form = document.getElementById('feature_s_form');
      let data = new FormData(feature_s_form);
      data.append('add_feature', '');

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "../admin/ajax/features_facilities.php", true);

      xhr.onload = function () {
  console.log("Response: ", this.responseText);
  if (parseInt(this.responseText) === 1) {
      console.log("Feature added successfully");
      showAlert('success', 'New feature added successfully!');
      feature_s_form.reset();
      get_features();
  } else {
      console.log("Failed to add feature");
      showAlert('error', 'Failed to add feature');
  }
};


      xhr.onerror = function () {
          console.log("Error occurred while processing the request.");
          showAlert('error', 'Server Down');
      };

      xhr.send(data);
  }



function get_features() {
let xhr = new XMLHttpRequest();
xhr.open("POST", "ajax/features_facilities.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function () {
    document.getElementById('features-data').innerHTML = this.responseText;
}
xhr.send('get_features');
}

function showAlert(type, message) {
  let bs_class = (type === "success") ? "alert-success" : "alert-danger";
  let alertDiv = document.createElement('div');
  alertDiv.classList.add("alert", "alert-dismissible", "fade", "show", "custom-alert", bs_class);
  alertDiv.setAttribute('role', 'alert');
  alertDiv.innerHTML = `
      <strong class="me-3">${message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  // Append the alert to the body or a specific container
  document.body.appendChild(alertDiv);

  // Auto-remove the alert after a few seconds (optional)
  setTimeout(() => {
      alertDiv.classList.remove('show');
      alertDiv.addEventListener('transitionend', () => alertDiv.remove());
  }, 3000);
}





function rem_feature(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (this.responseText.trim() === 'success') {
          showAlert('success', 'Feature removed successfully!');
          get_features();
      } else if (this.responseText.trim() === 'room_added') {
          showAlert('error', 'Feature is added in room');
      } else if (this.responseText.trim() === 'failed') {
          showAlert('error', 'Failed to remove feature. Server might be down or an error occurred.');
      } else {
          showAlert('error', 'Unexpected response from server: ' + this.responseText);
      }
  };

  xhr.onerror = function () {
      showAlert('error', 'Failed to connect to the server.');
  };

  xhr.send('rem_feature=' + id);
}



















function add_facility() {
  let facility_s_form = document.getElementById('facility_s_form');
  let data = new FormData();
  data.append('facility_name', facility_s_form.querySelector('input[name="facility_name"]').value);
  data.append('facility_icon', facility_s_form.querySelector('input[name="facility_icon"]').files[0]);
  data.append('facility_desc', facility_s_form.querySelector('textarea[name="facility_desc"]').value);
  data.append('add_facility', ''); // Append a flag to indicate this is an "add facility" request

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);


  xhr.onload = function () {
      if (this.responseText === 'inv_img') {
          alert('error', 'Invalid image format. Only SVG files are allowed.');
      } else if (this.responseText === 'inv_size') {
          alert('error', 'Image size should be less than 2MB.');
      } else if (this.responseText === 'upd_failed') {
          alert('error', 'Failed to upload image. Please try again later.');
      } else if (this.responseText === 'success') {
          alert('success', 'New Facility added successfully!');
          facility_s_form.reset();
          get_facilities(); // Reload the facilities list
      } else {
          alert('error', 'Unexpected response from server: ' + this.responseText);
      }
  };

  xhr.onerror = function () {
      alert('error', 'Failed to connect to the server.');
  };

  xhr.send(data); // Pass the FormData object here
}


function get_facilities() {
let xhr = new XMLHttpRequest();
xhr.open("POST", "ajax/features_facilities.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function () {
    document.getElementById('facilities-data').innerHTML = this.responseText;
}
xhr.send('get_facilities');
}

function rem_facility(id) {
let xhr = new XMLHttpRequest();
xhr.open("POST", "ajax/features_facilities.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function () {
    if (this.responseText.trim() === 'success') {
        alert('success', 'facility removed!');
        get_facilities(); 

  

    } else if (this.responseText.trim() === 'failed') {
        alert('error', 'Failed to remove feature. Server might be down or an error occurred.');
    } else {
        alert('error', 'Unexpected response from server: ' + this.responseText);
    }
};
xhr.onerror = function () {
    alert('error', 'Failed to connect to the server.');
};
xhr.send('rem_facility=' + id);
}


window.onload = function(){
get_features();
get_facilities();
}
