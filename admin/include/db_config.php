<?php

$hname = 'localhost';
$uname = 'root';
$pass = '';
$db ='hotel';
/*connection*/
$con = mysqli_connect($hname,$uname,$pass,$db);
if(!$con){
    die("Cannot Connect to Database" . mysqli_connect_error());
}

//frontend upload process needs this data
define('SITE_URL','http://127.0.0.1/hotel/');
define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
define('USER_IMG_PATH',SITE_URL.'images/user/');

//backend upload process needs this data
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/Hotel/images/');
define('ABOUT_FOLDER','about/');
define('CAROUSEL_FOLDER','carousel/');
define('FACILITIES_FOLDER','facilities/');
define('ROOMS_FOLDER','rooms/');
define('USER_FOLDER','user/');


function selectAll($table){
  $con = $GLOBALS['con'];
  $res = mysqli_query($con,"SELECT * FROM $table");
  return $res;
}


/*function for filtering the data*/
function filteration($data){
    foreach($data as $key => $value){
       $value= trim($value);  /*removing extra spaces*/
       $value = stripslashes($value); /*remove backword slashes*/
       $value = strip_tags($value);  /*remove html tags*/
       $value = htmlspecialchars($value); /*convert special char to html entities*/
       $data[$key]=$value;
    }
    return $data; /*return filtered data*/
}

/*select query function*/
function select($sql,$values,$datatypes){
    $con = $GLOBALS['con'];  /*using con variable globally inside the function*/
    if($smt = mysqli_prepare($con,$sql)){  /*if the sql query is prepare*/ 
      mysqli_stmt_bind_param($smt,$datatypes,...$values);  /*binding the prepare sql query, datatypes and values(we use slat operator to access multiple values)*/ 
      if(mysqli_stmt_execute($smt)){ /*if query is executed*/ 
          $res = mysqli_stmt_get_result($smt);  /*store the result in res variable*/ 
          mysqli_stmt_close($smt);  /*close the prepared sql query*/ 
          return $res;
        }
      else{
        mysqli_stmt_close($smt);  
        die("Query cannot be executed - Select");
      }
    }
    else{
        die("Query cannot be prepared - Select");
    }
}

/*update query function */
function update($sql,$values,$datatypes){
    $con = $GLOBALS['con'];  /*using con variable globally inside the function*/
    if($smt = mysqli_prepare($con,$sql)){  /*if the sql query is prepare*/ 
      mysqli_stmt_bind_param($smt,$datatypes,...$values);  /*binding the prepare sql query, datatypes and values(we use slat operator to access multiple values)*/ 
      if(mysqli_stmt_execute($smt)){ /*if query is executed*/ 
          $res =mysqli_stmt_affected_rows($smt);  /*store the result in res variable*/ 
          mysqli_stmt_close($smt);  /*close the prepared sql query*/ 
          return $res;
        }
      else{
        mysqli_stmt_close($smt);  
        die("Query cannot be executed - Update");
      }
    }
    else{
        die("Query cannot be prepared - Update");
    }
}

/*redirecting to the url of page*/
function redirect($url){
    echo"
      <script>
        window.location.href='$url'; 
      </script>
    ";
    exit;
}

/*alert function*/ 
function alert($type,$msg){

    $bs_class = ($type == "success") ? "alert-success"  :  "alert-danger";
    echo <<<alert
              <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3"> $msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <div>

             alert;
}

/*admin login function */
function adminLogin(){
    session_start();
    /*if adminLogin is present and its value is true is not present, redirect to hotel page*/
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        echo"<script>
           window.location.href='admin_hotel.php'; 
        </script>";
        exit;
    }
    // session_regenerate_id(true);
   
}

function uploadImage($image,$folder){
  // validating the type of the image
  $valid_mime = ['image/jpeg','image/png','image/webp'];
  // storing the type of image in variable
  $img_mime = $image['type'];
  //checking weather the type of image is present in array or not
  if(!in_array($img_mime,$valid_mime)){
    return 'inv_img'; //invalid image mine or format
  }//if size of image is greter than 2MB
  else if(($image['size']/(1024*1024))>2){
    return 'inv_size'; //invalid size 
  }
  else{
    //extract extention of image like-png
    $extention = pathinfo($image['name'],PATHINFO_EXTENSION);
    //generating random name for image(some certain range of int) like-IMG_1234.png
    $rname = 'IMG_'.random_int(11111,99999).".$extention";
    //generating the path of image like-Hotel/images/about/IMG_1234.png
    $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
    //move the image 
    if(move_uploaded_file($image['tmp_name'],$img_path)){
      return $rname;
    }else{
      return 'upd_failed';
    }
  }


}

/*insert query function*/
function insert($sql,$values,$datatypes){
  $con = $GLOBALS['con'];  /*using con variable globally inside the function*/
  if($smt = mysqli_prepare($con,$sql)){  /*if the sql query is prepare*/ 
    mysqli_stmt_bind_param($smt,$datatypes,...$values);  /*binding the prepare sql query, datatypes and values(we use slat operator to access multiple values)*/ 
    if(mysqli_stmt_execute($smt)){ /*if query is executed*/ 
        $res = mysqli_stmt_affected_rows($smt);  /*store the result in res variable*/ 
        mysqli_stmt_close($smt);  /*close the prepared sql query*/ 
        return $res;
      }
    else{
      mysqli_stmt_close($smt);  
      die("Query cannot be executed - Insert");
    }
  }
  else{
      die("Query cannot be prepared - Insert");
  }
}

/**delete image function */
function deleteImage($image, $folder){
  if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
    return true;
  }else{
    return false;
  }
}

/*delete query function */
function delete($sql,$values,$datatypes){
  $con = $GLOBALS['con'];  /*using con variable globally inside the function*/
  if($smt = mysqli_prepare($con,$sql)){  /*if the sql query is prepare*/ 
    mysqli_stmt_bind_param($smt,$datatypes,...$values);  /*binding the prepare sql query, datatypes and values(we use slat operator to access multiple values)*/ 
    if(mysqli_stmt_execute($smt)){ /*if query is executed*/ 
        $res =mysqli_stmt_affected_rows($smt);  /*store the result in res variable*/ 
        mysqli_stmt_close($smt);  /*close the prepared sql query*/ 
        return $res;
      }
    else{
      mysqli_stmt_close($smt);  
      die("Query cannot be executed - Delete");
    }
  }
  else{
      die("Query cannot be prepared - Delete");
  }
}

function uploadSvgImage($image,$folder){
  // validating the type of the image
  $valid_mime = ['image/svg+xml'];
  // storing the type of image in variable
  $img_mime = $image['type'];
  //checking weather the type of image is present in array or not
  if(!in_array($img_mime,$valid_mime)){
    return 'inv_img'; //invalid image mine or format
  }//if size of image is greter than 1MB
  else if(($image['size']/(1024*1024))>1){
    return 'inv_size'; //invalid size 
  }
  else{
    //extract extention of image like-png
    $extention = pathinfo($image['name'],PATHINFO_EXTENSION);
    //generating random name for image(some certain range of int) like-IMG_1234.png
    $rname = 'IMG_'.random_int(11111,99999).".$extention";
    //generating the path of image like-Hotel/images/about/IMG_1234.png
    $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
    //move the image 
    if(move_uploaded_file($image['tmp_name'],$img_path)){
      return $rname;
    }else{
      return 'upd_failed';
    }
  }


}

function uploadUserImage($image){
  $valid_mime = ['image/jpeg','image/png','image/webp'];
  $img_mime = $image['type'];
  if(!in_array($img_mime,$valid_mime)){
    return 'inv_img'; 
  }else{
    //extract extention of image like-png
    $extention = pathinfo($image['name'],PATHINFO_EXTENSION);
    //generating random name for image(some certain range of int) like-IMG_1234.png
    $rname = 'IMG_'.random_int(11111,99999).".jpeg";
    //generating the path of image like-Hotel/images/about/IMG_1234.png
    $img_path = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;
    
    if($extention == 'png' || $extention='PNG'){
    //returns an image identifier representing the image obtained from the given filename
    $img = imagecreatefrompng($image['tmp_name']);
    }else if($extention == 'wepb' || $extention='WEPB'){
    $img = imagecreatefromwebp($image['tmp_name']);
    }else{
      $img = imagecreatefromjpeg($image['tmp_name']);
    }

    //store the image 
    if(imagejpeg($img,$img_path,75)){
      return $rname;
    }else{
      return 'upd_failed';
    }
  }
}









?>