function get_bookings() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/refund_bookings.php", true);
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





function refund_booking(id){
  if (confirm("Refund money for  this booking?")) {
    let data = new FormData();
    data.append('booking_id', id);
    data.append('refund_booking', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_bookings.php", true);

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Money refunded!');
            get_bookings();
        } else {
            alert('error', 'Server Down');
        }
    };

    xhr.send(data);
  }
}




window.onload = function() {
  get_bookings(); 
};
