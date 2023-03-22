<?php   
require('../admin/include/db_config.php');
date_default_timezone_set("Asia/Kolkata");
session_start();

if(isset($_GET['fetch_rooms'])){
    
    $chk_ava = json_decode($_GET['chk_ava'],true);

    if($chk_ava['checkin']!='' && $chk_ava['checkout']!=''){
        $today_date= new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_ava['checkin']);
        $checkout_date = new DateTime($chk_ava['checkout']);

        if($checkin_date == $checkout_date){
            echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
            exit;
        }else  if($checkin_date < $today_date){
            echo"<h3 class='text-center text-danger'>chickin date must be greter than today's date!</h3>";
            exit;
        }else  if($checkout_date < $checkin_date){
            echo"<h3 class='text-center text-danger'>chickout date must be greter than checkin date!</h3>";
            exit;
        }
    }

    $guests = json_decode($_GET['guests'],true);
    $adult = ($guests['adult']!='') ? $guests['adult'] : 0;
    $children = ($guests['children']!='') ? $guests['children'] : 0;

    $facility_list=json_decode($_GET['facilities_list'],true);

    $count_rooms = 0;
    $output = '';
    //to heck the shutdown value
    $setting_query = "SELECT * FROM `settings` WHERE `sr_no`=1";
    $setting_res = mysqli_fetch_assoc(mysqli_query($con,$setting_query));

    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND  `status`=? AND `removed`=?", [$adult,$children,1, 0], 'iiii');
       
    while ($room_data = mysqli_fetch_assoc($room_res)) {
            
            //get facilities of room
            $fac_count=0;
            $fac_query = mysqli_query($con, "SELECT f.name, f.id FROM `facilities` f 
                                INNER JOIN `room_facilities` rfac ON f.id=rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
            $facilities_data = "";
            while ($fac_row = mysqli_fetch_assoc($fac_query)) {
                if(in_array($fac_row['id'],$facility_list['facilities'])){
                    $fac_count++;
                }
                $facilities_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap'>
                                       $fac_row[name]
                                    </sapn>";
            }
            if(count($facility_list['facilities'])!=$fac_count){
                continue;
            }

            //get features of room
            $fea_query = mysqli_query($con, "SELECT f.name FROM `features` f 
                                INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
            $features_data = "";
            while ($fea_row = mysqli_fetch_assoc($fea_query)) {
                $features_data .= "<sapn class='badge rounded-pill bg-light text-dark text-wrap'>
                                    $fea_row[name]
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
            $book_btn = '';
            if (!($setting_res['shutdown'])) {
                $book_btn = '<a href="#" class="btn btn-sm w-100 text-white mb-2 custom-bg shadow-none">Book Now</a>';
            }
            $output.="
                <div class='card mb-4 border-0 shadow'>
                    <div class='row g-0 p-3 align-items-center'>
                        <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                            <img src='$room_thumb' class='img-fluid rounded'>
                        </div>
                        <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                            <h5 class='mb-3'>$room_data[name]</h5>
                            <div class='features mb-3'>
                            <h6 class='mb-1'>Features</h6>
                            $features_data
                            </div>
                            <div class='facilities mb-3'>
                            <h6 class='mb-1'>Facilities</h6>
                            $facilities_data
                            </div>
                            <div class='guests'>
                            <h6 class='mb-1'>Guests</h6>
                            <sapn class='badge rounded-pill bg-light text-dark text-wrap '>$room_data[adult] Adults</sapn>
                            <sapn class='badge rounded-pill bg-light text-dark text-wrap '>$room_data[children]  Childern</sapn>
                            </div>
                        </div>
                        <div class='col-md-2 text-center mt-lg-0 mt-md-0 mt-4'> 
                            <h6 class='mb-4'>₹ $room_data[price] per night</h6>
                            $book_btn
                            <a href='rooms_details.php?id=$room_data[id]' class='btn w-100 btn-sm btn-outline-dark shadow-none'>Book Now</a>
                        </div>
                    </div>
                </div>
                ";
                $count_rooms++;
                }
                if($count_rooms>0){
                    echo $output;
                }else{
                    echo"<h3 class='text-center text-danger'>No rooms to show!</h3>";
                }

}
