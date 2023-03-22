<?php 
  require('../include/db_config.php');
  adminLogin();

  if(isset($_POST['add_image'])){
   
    $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);
    if($img_r == 'inv_img'){
      echo $img_r;
    }else if($img_r == 'inv_size'){
      echo $img_r;
    }else if($img_r == 'upd_failed'){
      echo $img_r;
    }else{
       
    $query = "INSERT INTO `carousel`(`image`) VALUES (?)";
    $values = [$img_r];
    $res = insert($query,$values,'s');
    echo $res;
    }
  }
  
  if(isset($_POST['get_carousel'])){
    $res = selectAll('carousel');
    while($row = mysqli_fetch_assoc($res))
    { //duplicate the member card
      $path = CAROUSEL_IMG_PATH;
      echo <<<data
          <div class="col-md-4 mb-3">
              <div class="card bg-dark text-white">
                  <img src="$path$row[image]" class="card-img" >
                  <div class="card-img-overlay text-end">
                      <button type="button" onclick="remove_image($row[sr_no])" class="btn btn-sm btn-danger shadow-none">
                        <i class="bi bi-trash"></i>  Delete
                      </button>
                  </div>
                
              </div>
          </div>

      data;
      
    }
  }

  if(isset($_POST['remove_image'])){
    $filt_data = filteration($_POST);
    $values = [$filt_data['remove_image']];
    $prep_query = "SELECT * FROM `carousel` WHERE `sr_no`=?";
    $res = select($prep_query,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
      $query = "DELETE FROM `carousel` WHERE `sr_no`=?";
      $res = delete($query,$values,'i');
      echo $res;
    }else{
      echo 0;
    }
  }
?>