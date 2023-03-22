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
    <title>Admin Login Panel-Settings</title>
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
                <h3 class="mb-4">SETTINGS</h3>
                <!--general setting section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-set">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text" id="site_about"></p>
                    </div>
                </div>
                <!--general setting Modal -->
                <div class="modal fade" id="general-set" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_form">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">General Settings</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Site Title</label>
                                            <input class="form-control shadow-none" id="site_title_input" required type="text" name="site_title"></input>
                                        </div>
                                        <div class=" mb-3">
                                            <label class="form-label fw-bold">About us</label>
                                            <textarea class="form-control shadow-none" id="site_about_input" required name="site_about" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="site_title.value = general_data.site_title,
                                                site_about.value = general_data.site_about">Cancle</button> <!-- onclicking cancle button, no changes in dtat-->
                                        <button type="submit"  class="btn text-white shadow-none custom-bg">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--shutdown section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input type="checkbox" onchange="upd_shutdown(this.value)" id="shutdown-toggle" class="form-check-input">
                                </form>
                            </div>
                        </div>
                        <p class="card-text">
                            No customers will be allowed to book hotel room when the shutdown mode is turned on.
                        </p>
                    </div>
                </div>
                <!-- contact details section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contact-set">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google map</h6>
                                    <p class="card-text" id="gm"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Contact number</h6>
                                    <p class="card-text mb-1"><i class="bi bi-telephone-fill"></i><span id="pn1"></span> </p>
                                    <p class="card-text"><i class="bi bi-telephone-fill"></i><span id="pn2"></span> </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1"><i class="bi bi-facebook me-1"></i><span id="fb"></span> </p>
                                    <p class="card-text mb-1"><i class="bi bi-instagram me-1"></i><span id="ins"></span> </p>
                                    <p class="card-text"><i class="bi bi-twitter"></i><span id="tw"></span> </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                                    <iframe loading="lazy" id="iframe" class="border p-2 w-100"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--contact details Modal -->
                <div class="modal fade " id="contact-set" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class= "modal-dialog modal-lg" >
                        <form id="contacts_form">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> Contacts Settings</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold ">Address</label>
                                                        <input class="form-control shadow-none" id="address_inp" required type="text" name="address"></input>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold ">Google Map Link</label>
                                                        <input class="form-control shadow-none" id="gm_inp" required type="text" name="gm"></input>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Phone number</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i> </span>
                                                            <input type="number" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                            <input type="number" name="pn2" id="pn2_inp" class="form-control shadow-none">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Email</label>
                                                        <input class="form-control shadow-none" id="email_inp" required type="email" name="email"></input>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Social Media Links</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-facebook"></i> </span>
                                                            <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                                            <input type="text" name="ins" id="ins_inp" class="form-control shadow-none" required>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-twitter"></i></span>
                                                            <input type="text" name="tw" id="tw_inp" class="form-control shadow-none">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">iFrame src</label>
                                                        <input class="form-control shadow-none" id="iframe_inp" required type="text" name="iframe"></input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick=contacts_inp(contacts_data)>
                                            Cancle</button> <!-- onclicking cancle button, no changes in dtat-->
                                        <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--management team setting section-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-set">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="team-data">

                        </div>
                    </div>
                </div>
                <!--management team setting Modal -->
                <div class="modal fade" id="team-set" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_form">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Team Memeber</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Member Name</label>
                                            <input class="form-control shadow-none" id="member_name_inp" required type="text" name="member_name"></input>
                                        </div>
                                        <div class=" mb-3">
                                            <label class="form-label">Picture</label>
                                            <input class="form-control shadow-none" accept=".jpg, .png, .webp, .jpeg" id="member_picture_inp" required type="file" name="member_picture"></input>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="member_name.value='', member_picture.value='' " class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="">
                                            Cancle</button>
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
    <script src="scripts/settings.js"> </script>

</body>

</html>