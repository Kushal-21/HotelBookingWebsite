 <!--bootstrap & icons link-->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
 <!--google font link-->
 <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Montserrat:wght@200&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <!--css link-->
 <link rel="stylesheet" href="css/common.css">
 <!--swiper css link-->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

 <!--including the php file-->
<?php 
 require('admin/include/db_config.php');

    $contact_query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $setting_query = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $contact_res = mysqli_fetch_assoc(select($contact_query, $values, 'i'));
    $setting_res = mysqli_fetch_assoc(select($setting_query, $values, 'i'));

    //when website is shutdown
    if($setting_res['shutdown']){
        echo<<<data
        <div class='bg-danger text-center p-2 fw-bold'> <i class='bi bi-exclamation-triangle-fill'></i> Bookinngs are temporarily closed!</div>
        data;
    }
    
?>
