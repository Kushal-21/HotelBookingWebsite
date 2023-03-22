<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $setting_res['site_title'] ?>-About</title>
    <style>
        .box {
            border-top-color: #2ec1ac !important;
        }
    </style>
</head>

<body class="bg-ligth">
    <!--including header.php file-->
    <?php require('include/header.php'); ?>

    <!--about section-->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos <br>iusto, repudiandae
            aliquid neque illum nostrum quis ea in commodi! Qui?
        </p>
    </div>

    <div class="container">
        <div class="row justified-content-between align-items-center ">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Lorem ipsum dolor sit</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Maxime possimus quo veritatis consequatur incidunt recusandae nulla!
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4  order-lg-2 order-md-2 order-1">
                <img src="images/about/person1.jpg" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.svg" width="70px">
                    <h4 class="mt-3">100+ Customers</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rating.svg" width="70px">
                    <h4 class="mt-3">100+ Reviews</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.svg" width="70px">
                    <h4 class="mt-3">100+ staff</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php
                  $about_res = selectAll('team_details') ;
                  $path = ABOUT_IMG_PATH;
                  while($row = mysqli_fetch_assoc($about_res)){
                    echo<<<data
                       <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                           <img src="$path$row[picture]" class="w-100">
                           <h5 class="mt-2">$row[member_name]</h5>
                        </div>
                     data;
                  }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>



    <!--including footer.php file-->
    <?php require('include/footer.php'); ?>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 40,
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