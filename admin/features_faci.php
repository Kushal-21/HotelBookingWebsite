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
    <title>Features & Facilities</title>
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
                <h3 class="mb-4">FEATURES & FACILITIES</h3>

                <!--features section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#features-set">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height:350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead >
                                    <tr class="bg-dark text-light ">
                                        <th scope="col">id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="feature_data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!--facilities section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facilities-set">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height:350px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead >
                                    <tr class="bg-dark text-light">
                                        <th scope="col">id</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" width="40%">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--features Modal -->
    <div class="modal fade" id="features-set" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feature_form">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Feature</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label"> Name</label>
                                <input class="form-control shadow-none" required type="text" name="feature_name"></input>
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
    <!--facilities Modal -->
    <div class="modal fade" id="facilities-set" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facilities_form">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Facilities</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label"> Name</label>
                                <input class="form-control shadow-none" required type="text" name="facilities_name"></input>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Icon</label>
                                <input class="form-control shadow-none" required type="file" accept=".svg" name="facilities_icon"></input>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control shadow-none" name="facilities_desc" required row="3"></textarea>
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

    <!--including script php file-->
    <?php require('include/script.php'); ?>
    <script>
        let feature_form = document.getElementById('feature_form');
        let facilities_form = document.getElementById('facilities_form');

        feature_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_feature();
        });

        function add_feature() {
            //loading the file through ajax
            let data = new FormData();
            data.append('name', feature_form.elements['feature_name'].value);

            data.append('add_feature', '');
            //ajax call
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.onload = function() {
                var myModal = document.getElementById('features-set');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert1('success', 'New feature added!');
                    feature_form.elements['feature_name'].value = '';
                    get_features();
                } else {
                    alert1('error', 'Server down!');
                }

            }
            xhr.send(data);
        }

        function get_features() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('feature_data').innerHTML = this.responseText;
            }
            xhr.send('get_features');
        }

        function remove_feature(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert1('success', 'Feature removed!');
                    get_features();
                } else if (this.responseText == 'room_added') {
                    alert1('error', 'Feature is added in the room');
                } else {
                    alert1('error', 'Server down!');
                }
            }
            xhr.send('remove_feature=' + val);

        }

        facilities_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_facilities();
        });

        function add_facilities() {
            //loading the file through ajax
            let data = new FormData();
            data.append('name', facilities_form.elements['facilities_name'].value);
            data.append('icon', facilities_form.elements['facilities_icon'].files[0]);
            data.append('description', facilities_form.elements['facilities_desc'].value);
            data.append('add_facilities', '');
            //ajax call
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.onload = function() {
                var myModal = document.getElementById('facilities-set');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 'inv_img') {
                    alert1('error', 'Only svg images are allowed!');
                    
                } else if (this.responseText == 'inv_size') {
                    alert1('error', 'Image should be less than 1MB!');
                } else if (this.responseText == 'upd_failed') {
                    alert1('error', 'Image upload faied. Server down!');
                } else {
                    alert1('success', 'New facility added!');
                    facilities_form.reset();
                    get_facilities();
                }

            }
            xhr.send(data);
        }
        function get_facilities() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('facilities_data').innerHTML = this.responseText;
            }
            xhr.send('get_facilities');
        }
        function remove_facilities(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert1('success', 'Facilities removed!');
                    get_facilities();
                } else if (this.responseText == 'room_added') {
                    alert1('error', 'Facilities is added in the room');
                } else {
                    alert1('error', 'Server down!');
                }
            }
            xhr.send('remove_facilities=' + val);

        }

        window.onload = function() {
            get_features();
            get_facilities();
        }
    </script>




</body>

</html>