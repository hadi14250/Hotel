function get_bookings(page = 1) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/booking_records.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status === 200) {
          let response = JSON.parse(xhr.responseText);
          document.getElementById('table-data').innerHTML = response.table_data;
          document.querySelector('.pagination').innerHTML = response.pagination;
      } else {
          console.error('Request failed. Status:', xhr.status);
      }
  };

  xhr.send('get_bookings&page=' + page);
}


// function download(id){

// window.location.href = 'generate_pdf.php?gen_pdf&id'+id;
// }

function download(id) {
  window.location.href = 'generate_pdf.php?gen_pdf=true&id=' + id;
}



window.onload = function() {
  get_bookings(); 
};
