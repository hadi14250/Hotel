document.addEventListener('DOMContentLoaded', function () {
  var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    effect: "fade",
    loop: true,
    autoplay: {
      delay: 2000, // 2 seconds delay
      disableOnInteraction: false,
    },
    slidesPerView: 1, // Show one slide at a time
  });



  var swiperTestimonials = new Swiper(".mySwiper-testimonials", {
    effect: "coverflow", 
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "3",
    slidesPerView: "auto",
    loop: true,
    coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: false,
          },

    pagination: {
      el: ".swiper-pagination",
    },
    breakpoints: {
      320: {
        slidesPerView: 1, // Show one slide at a time on small screens
      },
      640: {
        slidesPerView: 2, // Show two slides at a time on medium screens
      },
      768: {
        slidesPerView: 3, // Show three slides at a time on larger screens
      },
      1024: {
        slidesPerView: 3, // Show three slides at a time on desktops
      },
    },
  });
});







// document.addEventListener('DOMContentLoaded', function () {
//   let recoveryForm = document.getElementById("recovery-form");

//   recoveryForm.addEventListener('submit', function (e) {
//     e.preventDefault();

//     let formData = new FormData(recoveryForm);

//     let myModal = document.getElementById('recoveryModal');
//     var modal = bootstrap.Modal.getInstance(myModal);
//     modal.hide();

//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "ajax/reset.php", true);

//     xhr.onload = function () {
//       if (xhr.status === 200) {
//         if (xhr.responseText.trim() === 'Password updated successfully') {
//           alert('success', "Password  updated  successfully.");
//           recoveryForm.reset();
//         } else {
//           alert('error', "Failed to update password.");
//         }
//       } else {
//         alert('error', "An error occurred while processing the request.");
//       }
//     };

//     xhr.onerror = function () {
//       alert('error', "An error occurred while processing the request.");
//     };

//     xhr.send(formData);
//   });
// });

document.addEventListener('DOMContentLoaded', function () {
  let recoveryForm = document.getElementById("recovery-form");

  recoveryForm.addEventListener('submit', function (e) {
      e.preventDefault();

      let formData = new FormData(recoveryForm);

      let myModal = document.getElementById('recoveryModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/reset.php", true);

      xhr.onload = function () {
          if (xhr.status === 200) {
              if (xhr.responseText.trim() === 'Password updated successfully') {
                  showAlert('success', "Password updated successfully.");
                  recoveryForm.reset();
              } else {
                  showAlert('error', "Failed to update password.");
              }
          } else {
              showAlert('error', "An error occurred while processing the request.");
          }
      };

      xhr.onerror = function () {
          showAlert('error', "An error occurred while processing the request.");
      };

      xhr.send(formData);
  });

  function showAlert(type, message) {
      let alertContainer = document.getElementById('custom-alert-container');
      let alertDiv = document.createElement('div');
      alertDiv.textContent = message;
      alertDiv.classList.add('custom-alert');

      if (type === 'success') {
          alertDiv.classList.add('custom-alert-success');
      } else if (type === 'error') {
          alertDiv.classList.add('custom-alert-error');
      }

      alertContainer.appendChild(alertDiv);

      // Remove the alert after 5 seconds
      setTimeout(() => {
          alertDiv.remove();
      }, 5000);
  }
});

