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
    <title>Admin Login Panel-Carousel</title>
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
                <h3 class="mb-4">CAROUSEL</h3>
                
                <!--Carousel section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Images</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#carousel-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="carousel-data"></div>
                    </div>
                </div>
                <!--management team setting Modal -->
                <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="carousel_s_form">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Image</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class=" mb-3">
                                            <label class="form-label">Picture</label>
                                            <input class="form-control shadow-none" accept=".jpg, .png, .webp, .jpeg" id="carousel_picture_inp" required type="file" name="carousel_picture"></input>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="carousel_picture.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal" >Cancle</button>
                                        <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--including script php file-->
    <?php require('include/script.php'); ?>
    
    <script src="scripts/carousel.js"> </script>

</body>

</html>