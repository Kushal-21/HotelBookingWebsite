<?php 
  require('../include/db_config.php');
  adminLogin();

  if(isset($_POST['get_general'])){
    $query = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $res = select($query,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
  }

  if(isset($_POST['upd_general'])){
    $filt_data = filteration($_POST);
    $query ="UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
    $values = [$filt_data['site_title'], $filt_data['site_about'], 1];
    $res = update($query,$values,"ssi");
    echo $res;
  }

  if(isset($_POST['upd_shutdown'])){
    //if value of shutdown is 1 then make it 0 and vice versa
    $filt_data = ($_POST['upd_shutdown']==0) ? 1 : 0; 
    $query ="UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
    $values = [$filt_data, 1];
    $res = update($query,$values,"ii");
    echo $res;
  }

  if(isset($_POST['get_contacts'])){
    $query = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values = [1];
    $res = select($query,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
  }

  if(isset($_POST['upd_contacts'])){
    $filt_data = filteration($_POST);
    $query ="UPDATE `contact_details` SET `address`=?,`gm`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`ins`=?,`tw`=?,`iframe`=? WHERE `sr_no`=?";
    $values = [$filt_data['address'], $filt_data['gm'],$filt_data['pn1'],$filt_data['pn2'],$filt_data['email'],$filt_data['fb'],$filt_data['ins'],$filt_data['tw'],$filt_data['iframe'], 1];
    $res = update($query,$values,"sssssssssi");
    echo $res;
  }

  if(isset($_POST['add_member'])){
    $filt_data = filteration($_POST);
    $img_r = uploadImage($_FILES['picture'],ABOUT_FOLDER);
    if($img_r == 'inv_img'){
      echo $img_r;
    }else if($img_r == 'inv_size'){
      echo $img_r;
    }else if($img_r == 'upd_failed'){
      echo $img_r;
    }else{
       
    $query ="INSERT INTO `team_details` (`member_name`, `picture`) VALUES (?,?)";
    $values = [$filt_data['member_name'], $img_r];
    $res = insert($query,$values,"ss");
    echo $res;
    }
  }

  if(isset($_POST['get_members'])){
    $res = selectAll('team_details');
    while($row = mysqli_fetch_assoc($res))
    { //duplicate the member card
      $path = ABOUT_IMG_PATH;
      echo <<<data
      <div class="col-md-2 mb-3">
                                <div class="card bg-dark text-white">
                                    <img src="$path$row[picture]" class="card-img" >
                                    <div class="card-img-overlay text-end">
                                        <button type="button" onclick="remove_member($row[sr_no])" class="btn btn-sm btn-danger shadow-none">
                                          <i class="bi bi-trash"></i>  Delete
                                        </button>
                                    </div>
                                    <p class="card-text text-center px-3 py-2">$row[member_name]</p>
                                </div>
                            </div>

      data;
      
    }
  }

  if(isset($_POST['remove_member'])){
    $filt_data = filteration($_POST);
    $values = [$filt_data['remove_member']];
    $prep_query = "SELECT * FROM `team_details` WHERE `sr_no`=?";
    $res = select($prep_query,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['picture'],ABOUT_FOLDER)){
      $query = "DELETE FROM `team_details` WHERE `sr_no`=?";
      $res = delete($query,$values,'i');
      echo $res;
    }else{
      echo 0;
    }
  }
?>