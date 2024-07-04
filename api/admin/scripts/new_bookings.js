function get_bookings() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/new_bookings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status === 200) {
          document.getElementById('table-data').innerHTML = xhr.responseText;
      } else {
          console.error('Request failed. Status:', xhr.status);
      }
  };

  xhr.send('get_bookings');
}




let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id) {
  assign_room_form.elements['booking_id'].value = id;
}




assign_room_form.addEventListener('submit', function(e) {
  e.preventDefault();
  
  let data = new FormData(assign_room_form);
  data.append('assign_room', '');
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/new_bookings.php", true);
  
  xhr.onload = function() {
    var myModal = document.getElementById('assign-room');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    
    if (this.responseText == 1) {
      alert('success', 'Room Number Allotted! Booking Finalized');
      assign_room_form.reset();
      get_bookings();
    } else if (this.responseText == 2) {
      alert('error', 'Room has already been assigned!');
    } else {
      alert('error', 'Server Down!');
    }
  }; 
  
  xhr.send(data);
});


function cancel_booking(id){
  if (confirm("Are you sure you want to cancel this booking?")) {
    let data = new FormData();
    data.append('booking_id', id);
    data.append('cancel_booking', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Booking cancelled!');
            get_bookings();
        } else {
            alert('error', 'Server Down');
        }
    };

    xhr.send(data);
  }
}


// function searchBookings() {
//   let searchValue = document.getElementById('searchInput').value; // Get the search input value
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "ajax/search_bookings.php", true); // Use a new PHP file for search queries
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//   xhr.onload = function () {
//       if (xhr.status === 200) {
//           document.getElementById('table-data').innerHTML = xhr.responseText;
//       } else {
//           console.error('Request failed. Status:', xhr.status);
//       }
//   };

//   xhr.send('search=' + encodeURIComponent(searchValue)); // Send search parameter
// }

document.getElementById('searchInput').addEventListener('input', function() {
  let searchValue = document.getElementById('searchInput').value;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/new_bookings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status === 200) {
          document.getElementById('table-data').innerHTML = xhr.responseText;
      } else {
          console.error('Request failed. Status:', xhr.status);
      }
  };

  xhr.send('search=' + encodeURIComponent(searchValue));
});



window.onload = function() {
  get_bookings(); 
};
