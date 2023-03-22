<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $setting_res['site_title'] ?>-Home</title>
</head>

<body class="bg-ligth">
    <!--navbar section-->
    <?php require('include/header.php'); ?>

    <!--carousel section-->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                    $res = selectAll('carousel');
                    while ($row = mysqli_fetch_assoc($res)) {
                        $path = CAROUSEL_IMG_PATH;
                        echo <<<data
                            <div class="swiper-slide">
                                <img src="$path$row[image]" class="w-100 d-block" />
                            </div>
                        data;
                    }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!--check availability form section-->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="rooms.php">
                    <div class="row align-items-end ">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-in</label>
                            <input type="date" class="form-control shadow-none" required name="checkin">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-out</label>
                            <input type="date" class="form-control shadow-none" required name="checkout">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Adult</label>
                            <select class="form-select shadow-none" name="adult">
                            <?php 
                              $guests_query = mysqli_query($con,"SELECT MAX(adult) AS `max_adult`,MAX(children) AS `max_chld` 
                                                FROM `rooms` WHERE `status`='1' AND `removed`='0'");
                              $guests_res = mysqli_fetch_assoc($guests_query);

                              for($i=1;$i<=$guests_res['max_adult'];$i++){
                                echo"<option value='$i'>$i</option>";
                              }
                            ?>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Children</label>
                            <select class="form-select shadow-none" name="children">
                              <?php  for($i=1;$i<=$guests_res['max_chld'];$i++){
                                echo"<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availability">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Our rooms srection-->
    <h4 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h4>
    <div class="container">
        <div class="row">
            <?php
                    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC  LIMIT 3", [1,0], 'ii');
                    while ($room_data = mysqli_fetch_assoc($room_res)) {
                        //get features of room
                        $fea_query = mysqli_query($con, "SELECT f.name FROM `features` f 
                                            INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
                        $features_data = "";
                        while ($fea_row = mysqli_fetch_assoc($fea_query)) {
                            $features_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap'>
                                                $fea_row[name]
                                                </sapn>";
                        }
                        //get facilities of room
                        $fac_query = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                                            INNER JOIN `room_facilities` rfac ON f.id=rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                        $facilities_data = "";
                        while ($fac_row = mysqli_fetch_assoc($fac_query)) {
                            $facilities_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap'>
                                                $fac_row[name]
                                                </sapn>";
                        }
                        //get room thumbnail
                        $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                        $thumb_query = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
                        if (mysqli_num_rows($thumb_query) > 0) {
                            $thumb_res = mysqli_fetch_assoc($thumb_query);
                            $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                        }
                        //print room cards
                        $book_btn='';
                        if(!($setting_res['shutdown'])){
                            $book_btn='<a href="#" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>';
                        }
                        echo <<<data
                                    <div class="col-lg-4 col-md-6 my-3">
                                    <div class="card border-0 shadow" style="max-width: 350px; margin:auto;">
                                        <img src="$room_thumb" class="card-img-top">
                                        <div class="card-body">
                                            <h5>$room_data[name]</h5>
                                            <h6 class="mb-4">₹ $room_data[price] per night</h6>
                                            <div class="features mb-4">
                                                <h6 class="mb-1">Features</h6>
                                                $features_data
                                            </div>
                                            <div class="guests mb-4">
                                                <h6 class="mb-1">Guests</h6>
                                                <sapn class="badge rounded-pill bg-light text-dark text-wrap ">
                                                $room_data[adult] Adults
                                                </sapn>
                                                <sapn class="badge rounded-pill bg-light text-dark text-wrap ">
                                                $room_data[children] Childern
                                                </sapn>
                                            </div>
                                            <div class="facilities mb-4">
                                                <h6 class="mb-1">Facilities</h6>
                                                $facilities_data
                                            </div>
                                            <div class="rating mb-4">
                                                <h6 class="mb-1">Rating</h6>
                                                <sapn class="badge rounded-pill bg-light">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </sapn>
                                            </div>
                                            <div class="d-flex justify-content-evenly mb-2">
                                                $book_btn
                                                <a href="rooms_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            data;
                    }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
            </div>
        </div>
    </div>
    <!--Our facilities section-->
    <h4 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR Facilities</h4>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
                $res = mysqli_query($con,"SELECT * FROM `facilities`ORDER BY `id` DESC  LIMIT 5 ");
                $path = FACILITIES_IMG_PATH;
                while ($row = mysqli_fetch_assoc($res)) {
                    echo <<<data
                    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="$path$row[icon]" width="80px">
                    <h5 class="mt-3">$row[name]</h5>
                </div>
                data;
                }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
            </div>
        </div>
    </div>
    <!--Testimonials section-->
    <h4 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Testimonials</h4>
    <div class="container mt-5">
        <!-- Swiper -->
        <div class="swiper swiper-testimonials ">
            <div class="swiper-wrapper mb-5 ">
                <div class="swiper-slide bg-white rounded shadow p-4 ">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images//about/person1.jpg" class="rounded" width="30px">
                        <h6 class="m-0 ms-2">Roy</h6>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Expedita labore, tempore corrupti blanditiis enim omnis,
                        quam maiores delectus ea
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white rounded shadow p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/about/person2.jpg" class="rounded" width="30px">
                        <h6 class="m-0 ms-2">John</h6>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Expedita labore, tempore corrupti blanditiis enim omnis,
                        quam maiores delectus ea
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white rounded shadow p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/about/IMG_52782.png" class="rounded" width="30px">
                        <h6 class="m-0 ms-2">David</h6>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Expedita labore, tempore corrupti blanditiis enim omnis,
                        quam maiores delectus ea
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More >>></a>
        </div>
    </div>

    <!--Reach us section-->
    <h4 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h4>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded shadow">
                <iframe class="w-100 rounded" src="<?php echo $contact_res['iframe'] ?>" height="320px" style="border:0;" loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white rounded shadow p-4 mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +<?php echo $contact_res['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-drk"><i class="bi bi-telephone-fill"></i> +<?php echo $contact_res['pn1'] ?></a><br>
                    <?php
                    if ($contact_res['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_res[pn2]" class="d-inline-block  text-decoration-none text-drk"><i class="bi bi-telephone-fill"></i> +$contact_res[pn2]</a>
                        data;
                    }
                    ?>
                </div>
                <div class="bg-white rounded shadow p-4  mb-4">
                    <h5>Follow us</h5>
                    <?php
                    if ($contact_res['tw'] != '') {
                        echo <<<data
                    <a href="$contact_res[tw]" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i> Twitter
                        </span>
                    </a><br>
                    data;
                    }
                    ?>
                    <a href="<?php echo $contact_res['fb'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </span>
                    </a><br>
                    <a href="<?php echo $contact_res['ins'] ?>" class="d-inline-block ">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--including footer.php file-->
    <?php require('include/footer.php'); ?>

    <!--bundle js file-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            delay: 3500,
            disableOnInteraction: false
        });
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
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
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    </script>
</body>

</html>