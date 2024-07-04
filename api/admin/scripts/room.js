let add_room_form = document.getElementById("add_room_form");
add_room_form.addEventListener('submit', function(e){
  e.preventDefault();
  add_room();
});

function add_room(){
let add_room_form = document.getElementById('add_room_form');
let data = new FormData();
data.append('add_room', '');
data.append('name', add_room_form.elements['name'].value);
data.append('area', add_room_form.elements['area'].value);
data.append('price', add_room_form.elements['price'].value);
data.append('quantity', add_room_form.elements['quantity'].value);
data.append('adult', add_room_form.elements['adult'].value);
data.append('children', add_room_form.elements['children'].value);
data.append('desc', add_room_form.elements['desc'].value);

// Convert HTML collections to arrays
let features = Array.from(add_room_form.elements['features']);
let facilities = Array.from(add_room_form.elements['facilities']);

// Filter checked elements
features = features.filter(el => el.checked).map(el => el.value);
facilities = facilities.filter(el => el.checked).map(el => el.value);

data.append('features', JSON.stringify(features));
data.append('facilities', JSON.stringify(facilities));

let xhr = new XMLHttpRequest();
xhr.open("POST", "ajax/rooms.php", true);

xhr.onload = function () {
    console.log("Response: ", this.responseText);
    try {
        let response = JSON.parse(this.responseText);
        if (response.success) {
            console.log("room added successfully");
            showAlert('success', 'New room added successfully!');
            add_room_form.reset();
            get_all_rooms();
        } else {
            console.log("Failed to add room");
            showAlert('error', 'Failed to add room');
        }
    } catch (error) {
        console.error("Error parsing JSON: ", error);
        showAlert('error', 'Server error occurred');
    }
};

xhr.onerror = function () {
    console.log("Error occurred while processing the request.");
    showAlert('error', 'Server Down');
};

xhr.send(data);
};


function showAlert(type, message) {
let bs_class = (type === "success") ? "alert-success" : "alert-danger";
let alertDiv = document.createElement('div');
alertDiv.classList.add("alert", "alert-dismissible", "fade", "show", "custom-alert", bs_class);
alertDiv.setAttribute('role', 'alert');
alertDiv.innerHTML = `
    <strong class="me-3">${message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
`;
document.body.appendChild(alertDiv);
}


function get_all_rooms(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      document.getElementById('room-data').innerHTML = this.responseText;
  };

  xhr.send('get_all_rooms=1'); // Send the parameter properly
}


function toggleStatus(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      try {
          let response = JSON.parse(this.responseText);
          if (response.success) {
              showAlert('success', 'Status toggled');
              get_all_rooms();
          } else {
              showAlert('error', 'Failed to toggle status');
          }
      } catch (error) {
          console.error("Error parsing JSON: ", error);
          showAlert('error', 'Server error occurred');
      }
  };

  xhr.onerror = function () {
      console.log("Error occurred while processing the request.");
      showAlert('error', 'Server Down');
  };

  xhr.send('toggleStatus=' + id + '&value=' + val);
}



function edit_details(id) {
let edit_room_form = document.getElementById("edit_room_form");
let xhr = new XMLHttpRequest();
xhr.open("POST", "ajax/rooms.php", true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onload = function () {
    if (xhr.status === 200) {
        console.log("Response: ", this.responseText); // Check the response
        try {
            if (this.responseText.trim() !== "") { // Check if response is not empty
                let data = JSON.parse(this.responseText);
                console.log("Received Data: ", data); // Check the parsed data
                if (data && Object.keys(data).length > 0) { // Check if data is not empty
                    if (data.roomdata) { // Check if roomdata exists
                        edit_room_form.elements['name'].value = data.roomdata.name;
                        edit_room_form.elements['area'].value = data.roomdata.area;
                        edit_room_form.elements['price'].value = data.roomdata.price;
                        edit_room_form.elements['quantity'].value = data.roomdata.quantity;
                        edit_room_form.elements['adult'].value = data.roomdata.adult;
                        edit_room_form.elements['children'].value = data.roomdata.children;
                        edit_room_form.elements['desc'].value = data.roomdata.description;
                        edit_room_form.elements['room_id'].value = data.roomdata.id;

                        // Reset checkbox states
                        edit_room_form.querySelectorAll('input[name="features"]').forEach(el => {
                            el.checked = false;
                        });

                        edit_room_form.querySelectorAll('input[name="facilities"]').forEach(el => {
                            el.checked = false;
                        });

                        // Check checkboxes based on received data
                        data.features.forEach(feature => {
                            let checkbox = edit_room_form.querySelector(`input[name="features"][value="${feature}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });

                        data.facilities.forEach(facility => {
                            let checkbox = edit_room_form.querySelector(`input[name="facilities"][value="${facility}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    } else {
                        console.error("No room data received or incorrect response format");
                    }
                } else {
                    console.error("Empty response or incorrect format");
                }
            } else {
                console.error("Empty response received");
            }
        } catch (error) {
            console.error("Error parsing JSON: ", error);
            showAlert('error', 'Server error occurred');
        }
    } else {
        console.error("Request failed with status:", xhr.status);
        showAlert('error', 'Server error occurred');
    }
};

xhr.onerror = function () {
    console.error("Request failed");
    showAlert('error', 'Server error occurred');
};

xhr.send("get_room=" + id); // Send the request with the room ID
}





function submit_edit_room() {
  let edit_room_form = document.getElementById("edit_room_form");
  let data = new FormData(edit_room_form);

  let features = [];
  edit_room_form.querySelectorAll('input[name="features"]').forEach(el => {
      if (el.checked) {
          features.push(el.value);
      }
  });

  let facilities = [];
  edit_room_form.querySelectorAll('input[name="facilities"]').forEach(el => {
      if (el.checked) {
          facilities.push(el.value);
      }
  });

  data.append('features', JSON.stringify(features));
  data.append('facilities', JSON.stringify(facilities));
  
  // Append 'edit_room' key to indicate an edit request
  data.append('edit_room', ''); 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
      if (xhr.status === 200) {
          try {
              const responseText = this.responseText.trim();
              if (responseText) {
                  const responseData = JSON.parse(responseText);
                  if (responseData.success) {
                      console.log("Room edit successful");
                      showAlert('success', 'Room edited successfully');
                      get_all_rooms(); // Update the room data without reloading the page
                  } else {
                      console.error("Failed to edit room");
                      showAlert('error', 'Failed to edit room');
                  }
              } else {
                  console.error("Empty response received");
                  showAlert('error', 'Empty response received');
              }
          } catch (error) {
              console.error("Error parsing JSON:", error);
              showAlert('error', 'Server error occurred');
          }
      } else {
          console.error("Request failed with status:", xhr.status);
          showAlert('error', 'Server error occurred');
      }
  };

  xhr.onerror = function () {
      console.error("Error occurred while processing the request.");
      showAlert('error', 'Server Down');
  };

  xhr.send(data);
}


let add_image_form= document.getElementById("add_image_form");

add_image_form.addEventListener('submit',function(e){

e.preventDefault();
add_image();
});

function add_image() {
  let data = new FormData();
  data.append('image', add_image_form.elements['image'].files[0]);
  data.append('room_id', add_image_form.elements['room_id'].value);
  data.append('add_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
      console.log("Response from server:", this.responseText); // Log the response for debugging
      if (this.responseText === 'inv_img') {
          alert('error', 'Invalid image format. Only PNG, JPG, or JPEG files are allowed.','image-alert');
      } else if (this.responseText === 'inv_size') {
          alert('error', 'Image size should be less than 2MB.','image-alert');
      } else if (this.responseText === 'upd_failed') {
          alert('error', 'Failed to upload image. Please try again later.','image-alert');
      } else if (this.responseText === 'success') {
          alert('success', 'New image added !','image-alert');
          room_images(add_image_form.elements['room_id'].value,document.querySelector("#room-images .modal-title").innerText);
          add_image_form.reset();
          
           
      } else {
          alert('error', 'Unexpected response from server: ' + this.responseText);
      }
  };

  xhr.onerror = function () {
      alert('error', 'Failed to connect to the server.');
  };

  xhr.send(data);
}




function room_images(id, rname) {
  let modalTitle = document.querySelector("#room-images .modal-title");
  if (modalTitle) {
      modalTitle.innerText = rname;
      add_image_form.elements['room_id'].value = id;
      add_image_form.elements['image'].value = '';

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/rooms.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function () {
          document.getElementById('room-image-data').innerHTML = this.responseText;
      };

      xhr.send('get_room_images=' + id);
  } else {
      console.error("Modal title element not found.");
  }
}




function rem_image(img_id, room_id) {
  let data = new FormData();
  data.append('image_id', img_id);
  data.append('room_id', room_id);
  data.append('rem_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
      if (this.responseText.trim() === "success") {
          alert('success', 'Image Removed!', 'image-alert');
          room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
      } else {
          alert('error', 'Image removal failed: ' + this.responseText, 'image-alert');
      }
  };

  xhr.send(data);
}

window.onload = function() {
  get_all_rooms(); 
};




function thumb_image(img_id, room_id) {
  let data = new FormData();
  data.append('image_id', img_id);
  data.append('room_id', room_id);
  data.append('thumb_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
      if (this.responseText==1) {
          alert('success', 'Image thumbnail changed!', 'image-alert');
          room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
      } else {
          alert('error', 'thumbnail update failed: ' , 'image-alert');
      }
  };

  xhr.send(data);
}


function remove_room(room_id) {


if(confirm("Are u sure,u want to delete this room ?")){
  let data = new FormData();
  data.append('room_id', room_id);
  data.append('remove_room', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
      if (this.responseText==1) {
          alert('success', 'Room removed!');
          get_all_rooms();
      } else {
          alert('error', 'Room removal failed' );
      }
  };

  xhr.send(data);
}
  

}

window.onload = function() {
  get_all_rooms(); 
};
