let carousel_s_form = document.getElementById('carousel_s_form');
let carousel_picture_inp = document.getElementById('carousel_picture_inp');

carousel_s_form.addEventListener('submit', function(e) {
    e.preventDefault(); 
    add_image(); 
});

function add_image() {
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);

    xhr.onload = function () {
        console.log("Response from server:", this.responseText); // Log the response for debugging
        if (this.responseText === 'inv_img') {
            alert('error', 'Invalid image format. Only PNG, JPG, or JPEG files are allowed.');
        } else if (this.responseText === 'inv_size') {
            alert('error', 'Image size should be less than 2MB.');
        } else if (this.responseText === 'upd_failed') {
            alert('error', 'Failed to upload image. Please try again later.');
        } else if (this.responseText === 'success') {
            alert('success', 'New image added successfully!');
            carousel_picture_inp.value = '';
            get_carousel(); 
        } else {
            alert('error', 'Unexpected response from server: ' + this.responseText);
        }
    };

    xhr.onerror = function () {
        alert('error', 'Failed to connect to the server.');
    };

    xhr.send(data);
}

function get_carousel() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }
    xhr.send('get_carousel');
}

function rem_image(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText.trim() === 'success') {
            alert('success', 'Image removed!');
            get_carousel(); 
        } else if (this.responseText.trim() === 'failed') {
            alert('error', 'Failed to remove image. Server might be down or an error occurred.');
        } else {
            alert('error', 'Unexpected response from server: ' + this.responseText);
        }
    };
    xhr.onerror = function () {
        alert('error', 'Failed to connect to the server.');
    };
    xhr.send('rem_image=' + id);
}

window.onload = function () {
    get_carousel();
};
