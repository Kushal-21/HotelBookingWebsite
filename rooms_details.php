<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $setting_res['site_title'] ?>-Rooms Details</title>
</head>

<body class="bg-ligth">
    <!--including header.php file-->
    <?php require('include/header.php'); ?>

    <?php
        if (!isset($_GET['id'])) {
            redirect('rooms.php');
        }
        $data = filteration($_GET);
        $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
        if (mysqli_num_rows($room_res) == 0) {
            redirect('rooms.php');
        }
        $room_data = mysqli_fetch_assoc($room_res);
    ?>
    <!--filter & cards section-->
    <div class="container">
        <div class="row">
            <!--rooms section-->
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="hotel.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                            //get room thumbnail
                            $room_img = ROOMS_IMG_PATH . "thumbnail.jpg";
                            $thumb_query = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                            if (mysqli_num_rows($thumb_query) > 0) {
                                $active_class = 'active';
                                while ($img_res = mysqli_fetch_assoc($thumb_query)) {
                                    echo "<div class='carousel-item $active_class'>
                                    <img class='d-block w-100' src='" . ROOMS_IMG_PATH . $img_res['image'] . "'>
                                    </div>";
                                    $active_class = '';
                                }
                            } else {
                                echo "<div class='carousel-item active'>
                                            <img class='d-block w-100 rounded' src='$room_img'>
                                        </div>
                                    ";
                            }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#roomCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#roomCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<price
                         <h4>₹$room_data[price] per night</h4>
                         price;

                        echo <<<rating
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                         rating;

                        //get features of room
                        $fea_query = mysqli_query($con, "SELECT f.name FROM `features` f 
                                        INNER JOIN `room_features` rfea ON f.id=rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
                        $features_data = "";
                        while ($fea_row = mysqli_fetch_assoc($fea_query)) {
                            $features_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                               $fea_row[name]
                                            </sapn>";
                        }
                        echo <<<feature
                                <div class="features mb-3">
                                    <h6 class="mb-1">Features</h6>$features_data
                                </div>
                         feature;

                        //get facilities
                        $fac_query = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                                       INNER JOIN `room_facilities` rfac ON f.id=rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                        $facilities_data = "";
                        while ($fac_row = mysqli_fetch_assoc($fac_query)) {
                            $facilities_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                               $fac_row[name]
                                               </sapn>";
                        }
                        echo <<<facilities
                           <div class="features mb-3">
                              <h6 class="mb-1">Facilities</h6>$facilities_data
                           </div>
                        facilities;
 
                        //get guests
                        echo <<<guest
                               <div class="mb-3">
                                  <h6 class="mb-1">Guests</h6>
                                  <sapn class="badge rounded-pill bg-light text-dark text-wrap ">
                                    $room_data[adult] Adults
                                  </sapn>
                                  <sapn class="badge rounded-pill bg-light text-dark text-wrap ">
                                    $room_data[children]  Childern
                                  </sapn>
                               </div>
                        guest;

                        //get area
                        echo <<<area
                                <div class="mb-3">
                                  <h6 class="mb-1">Area</h6>
                                  <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                  $room_data[area] sq.ft.
                                  </span>
                                </div>
                        area;

                        if (!($setting_res['shutdown'])) {
                         echo <<<book
                                  <a href="#" class="btn  w-100 text-white custom-bg shadow-none mb-1">Book Now</a>
                            book;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class=" col-12 mt-4 px-4">
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>
                        <?php echo $room_data['description'] ?>
                    </p>
                </div>
                <div>
                    <h5 class="mb-3">Reviews & Ratings</h5>
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <img src="images/about/person1.jpg" width="30px">
                            <h6 class="m-0 ms-2">user 1</h6>
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
        </div>
    </div>



    <!--including footer.php file-->
    <?php require('include/footer.php'); ?>

</body>

</html>