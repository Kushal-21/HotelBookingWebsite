<!--connecting db_config file-->
<?php require('include/db_config.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <?php require('include/links.php'); ?>
    <style>
        .custom-alert {
            position: fixed;
            top: 80px;
            right: 25px;
        }
    </style>
</head>

<body class="bg-light">
    <!--conecting admin_header file-->
    <?php require('include/admin_header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 p-4 ms-auto overflow-hidden">
                <h3 class="mb-4">ROOMS</h3>

                <!--rooms section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-4 text-end">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height:450px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light text-center ">
                                        <th scope="col">id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room_data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--add room Modal -->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog  ">
            <form id="room_form" autocomplete="off">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Room</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Name</label>
                                    <input class="form-control shadow-none" required type="text" name="name"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Area</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="area"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Quantity</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="quantity"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Price</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="price"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Adult</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="adult"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Children</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="children"></input>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label class="form-label fw-bold">Features</label>
                                    <div class="row">
                                        <?php
                                        $res = selectAll('features');
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                              <div class='col-md-3 mb-1'>
                                                   <label>
                                                      <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'></input>
                                                      $opt[name]
                                                   </label>
                                                </div>
                                            ";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label class="form-label fw-bold">Facilities</label>
                                    <div class="row">
                                        <?php
                                        $res = selectAll('facilities');
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                              <div class='col-md-3 mb-1'>
                                                   <label>
                                                      <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'></input>
                                                      $opt[name]
                                                   </label>
                                                </div>
                                            ";
                                        }
                                        ?> 
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control shadow-none" required rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--edit room Modal -->
    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_room_form" autocomplete="off">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Room</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Name</label>
                                    <input class="form-control shadow-none" required type="text" name="name"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Area</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="area"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Quantity</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="quantity"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Price</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="price"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Adult</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="adult"></input>
                                </div>
                                <div class="co-md-6 mb-3">
                                    <label class="form-label fw-bold"> Children</label>
                                    <input class="form-control shadow-none" min="1" required type="number" name="children"></input>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label class="form-label fw-bold">Features</label>
                                    <div class="row">
                                        <?php
                                        $res = selectAll('features');
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                              <div class='col-md-3 mb-1'>
                                                   <label>
                                                      <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'></input>
                                                      $opt[name]
                                                   </label>
                                                </div>
                                            ";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label class="form-label fw-bold">Facilities</label>
                                    <div class="row">
                                        <?php
                                        $res = selectAll('facilities');
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                              <div class='col-md-3 mb-1'>
                                                   <label>
                                                      <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'></input>
                                                      $opt[name]
                                                   </label>
                                                </div>
                                            ";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control shadow-none" required rows="4"></textarea>
                                </div>
                                <input type="hidden" name="room_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--manage room image modal -->
    <div class="modal fade" id="room-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room Name</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pd-3 mb-3">
                        <form action="" id="add_image_form">
                            <label class="form-label">Add Image</label>
                            <input class="form-control shadow-none mb-3" type="file" required name="image"></input>
                            <button class="btn text-white shadow-none custom-bg">Add</button>
                            <input type="hidden" name="room_id">
                        </form>

                        <div class="table-responsive-lg" style="height:350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light text-center sticky-top">
                                        <th scope="col" width="60%">Image</th>
                                        <th scope="col">Thumbnail</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="room_image_data">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--including script php file-->
    <?php require('include/script.php'); ?>

    <script>
        let room_form = document.getElementById('room_form');
        room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_room();
        });
        let edit_room_form = document.getElementById('edit_room_form');
        edit_room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_room();
        });
        let add_image_form = document.getElementById('add_image_form');
        add_image_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_image();
        });

        function add_room() {
            let data = new FormData();
            data.append('add_room', '');
            data.append('name', room_form.elements['name'].value);
            data.append('area', room_form.elements['area'].value);
            data.append('quantity', room_form.elements['quantity'].value);
            data.append('price', room_form.elements['price'].value);
            data.append('adult', room_form.elements['adult'].value);
            data.append('children', room_form.elements['children'].value);
            data.append('description', room_form.elements['description'].value);
            //featching the values of feature & facilities
            let features = [];
            room_form.elements['features'].forEach(el => {
                if (el.checked) {
                    features.push(el.value); //push the value into array
                }
            });
            let facilities = [];
            room_form.elements['facilities'].forEach(el =>{
                if(el.checked){
                    facilities.push(el.value);//push the value into array
                }
            });
            //converting value into jason format & then append
            data.append('features', JSON.stringify(features));
            data.append('facilities',JSON.stringify(facilities));
            //ajax call
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.onload = function() {

                var myModal = document.getElementById('add-room');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                if (this.responseText == 1) {
                    alert1('success', 'Room added!');
                    room_form.reset();
                    get_all_rooms();

                } else {
                    alert1('error', 'Server Down!');

                }

            }
            xhr.send(data);
        }

        function get_all_rooms() {
            //ajax call
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('room_data').innerHTML = this.responseText;
            }
            xhr.send('get_all_rooms');
        }

        function toggle_status(id, value) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert1('success', 'Status updated!');
                    get_all_rooms();
                } else {
                    alert1('success', 'Server down!');
                }
            }
            xhr.send('toggle_status=' + id + '&value=' + value);
        }

        function edit_details(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                edit_room_form.elements['name'].value = data.roomdata.name;
                edit_room_form.elements['area'].value = data.roomdata.area;
                edit_room_form.elements['quantity'].value = data.roomdata.quantity;
                edit_room_form.elements['price'].value = data.roomdata.price;
                edit_room_form.elements['adult'].value = data.roomdata.adult;
                edit_room_form.elements['children'].value = data.roomdata.children;
                edit_room_form.elements['description'].value = data.roomdata.description;
                edit_room_form.elements['room_id'].value = data.roomdata.id;
                
                edit_room_form.elements['facilities'].forEach(el => {
                    if (data.facilities.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });
                edit_room_form.elements['features'].forEach(el => {
                    if (data.features.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });

            }
            xhr.send('get_room=' + id);
        }

        function submit_edit_room() {
            let data = new FormData();
            data.append('edit_room', '');
            data.append('room_id', edit_room_form.elements['room_id'].value);
            data.append('name', edit_room_form.elements['name'].value);
            data.append('area', edit_room_form.elements['area'].value);
            data.append('quantity', edit_room_form.elements['quantity'].value);
            data.append('price', edit_room_form.elements['price'].value);
            data.append('adult', edit_room_form.elements['adult'].value);
            data.append('children', edit_room_form.elements['children'].value);
            data.append('description', edit_room_form.elements['description'].value);

            let features = [];
            edit_room_form.elements['features'].forEach(el => {
                if(el.checked) {
                    features.push(el.value); //push the value into array
                }
            });
            let facilities = [];
            room_form.elements['facilities'].forEach(el =>{
                if(el.checked){
                    facilities.push(el.value);//push the value into array
                }
            });
            //converting value into jason format & then append
            data.append('features', JSON.stringify(features));
            data.append('facilities',JSON.stringify(facilities));

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.onload = function() {
                var myModal = document.getElementById('edit-room');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                if (this.responseText == 1) {
                    alert1('success', 'Room data edited!');
                    edit_room_form.reset();
                    get_all_rooms();

                } else {
                    alert1('error', 'Server Down!');

                }

            }
            xhr.send(data);
        }

        function add_image() {
            //loading the file through ajax
            let data = new FormData();

            data.append('image',add_image_form.elements['image'].files[0]);
            data.append('room_id',add_image_form.elements['room_id'].value);
            data.append('add_image', '');
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.onload = function() {

                if (this.responseText == 'inv_img') {
                    alert1('error', 'Only jpg and png images are allowed!','image-alert');
                    
                } else if (this.responseText == 'inv_size') {
                    alert1('error', 'Image should be less than 2MB!','image-alert');
                } else if (this.responseText == 'upd_failed') {
                    alert1('error', 'Image upload faied. Server down!','image-alert');
                } else {
                    alert1('success', 'New image added!','image-alert');
                    room_images(add_image_form.elements['room_id'].value,document.querySelector("#room-image .modal-title").innerText);
                    add_image_form.reset();
                }

            }
            xhr.send(data);
        }

        function room_images(id,rname){
            document.querySelector("#room-image .modal-title").innerText = rname;
            add_image_form.elements['room_id'].value=id;
            add_image_form.elements['image'].value='';

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('room_image_data').innerHTML=this.responseText;
            }
            xhr.send('get_room_images='+id);
 

        }

        function remove_image(img_id,room_id) {
         
            let data = new FormData();
            data.append('image_id',img_id);
            data.append('room_id',room_id);
            data.append('remove_image', '');
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert1('success', 'Image Removed!','image-alert');
                    room_images(room_id,document.querySelector("#room-image .modal-title").innerText);
                }else{
                    alert1('error','Image removal failed','image-alert');
                }
            }
            xhr.send(data);
        }

        function thumb_image(img_id,room_id) {
         
         let data = new FormData();
         data.append('image_id',img_id);
         data.append('room_id',room_id);
         data.append('thumb_image', '');
         
         let xhr = new XMLHttpRequest();
         xhr.open("POST", "ajax/rooms.php", true);
         xhr.onload = function() {
             if (this.responseText == 1) {
                 alert1('success', 'Image Thumbnail set','image-alert');
                 room_images(room_id,document.querySelector("#room-image .modal-title").innerText);
             }else{
                 alert1('error','Thumbnail failed','image-alert');
             }
         }
         xhr.send(data);
        }

        function remove_room(room_id) {
         if(confirm("Are you sure, you want to delete this room?")){
             let data = new FormData();
             data.append('room_id',room_id);
             data.append('remove_room', '');
             let xhr = new XMLHttpRequest();
             xhr.open("POST", "ajax/rooms.php", true);
             xhr.onload = function() {
                 if (this.responseText == 1) {
                     alert1('success', 'Room removed!');
                     get_all_rooms();
                 }else{
                     alert1('error','Room removal failed');
                 }
             }
             xhr.send(data);
             
         }
         
        }
         window.onload = function() {
            get_all_rooms();
        }
    </script>




</body>

</html>