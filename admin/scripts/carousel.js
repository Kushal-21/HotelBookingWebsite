let carousel_s_form = document.getElementById('carousel_s_form');
let carousel_picture_inp = document.getElementById('carousel_picture_inp');

carousel_s_form.addEventListener('submit', function(e) {
    e.preventDefault(); 
    add_image();
});

//add member function
function add_image() {
    //loading the file through ajax
    let data = new FormData();

    data.append('picture', carousel_picture_inp.files[0]); 
    data.append('add_image', '');
    //ajax call
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.onload = function() {

        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 'inv_img') {
            alert1('error', 'Only jpg and png images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert1('error', 'Image should be less than 2MB!');
        } else if (this.responseText == 'upd_failed') {
            alert1('error', 'Image upload faied. Server down!');
        } else {
            alert1('success', 'New image added!');
             carousel_picture_inp.value = '';
            get_carousel();
        }

    }
    xhr.send(data);
}

function get_carousel() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }
    xhr.send('get_carousel');
}
function remove_image(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert1('success', 'Image removed!');
            get_carousel();
        } else {
            alert1('error', 'Server down!');
        }
    }
    xhr.send('remove_image=' + val);

}


window.onload = function() {
    get_carousel();
}