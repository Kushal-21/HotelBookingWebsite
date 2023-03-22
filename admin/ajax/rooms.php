<?php 
  require('../include/db_config.php');
  adminLogin();
  
  if(isset($_POST['add_room'])){
    $features=filteration(json_decode($_POST['features']));
    $facilities=filteration(json_decode($_POST['facilities']));
    $filt_data = filteration($_POST);
    $flage =0;

    $query="INSERT INTO `rooms`(`name`, `area`, `quantity`, `price`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $value=[$filt_data['name'],$filt_data['area'],$filt_data['quantity'],$filt_data['price'],$filt_data['adult'],$filt_data['children'],$filt_data['description']];

    if(insert($query,$value,'siiiiis')){
      $flage =1;
    }
    $room_id=mysqli_insert_id($con);

    $query2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if($smt = mysqli_prepare($con,$query2)){
      foreach($facilities as $f){
        mysqli_stmt_bind_param($smt,'ii',$room_id,$f);
        mysqli_stmt_execute($smt);
      }
      mysqli_stmt_close($smt);
    }else{
      $flage=0;
      die('Query cannot be prepares - insert');
    }

    $query3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if($smt = mysqli_prepare($con,$query3)){
      foreach($features as $f){
        mysqli_stmt_bind_param($smt,'ii',$room_id,$f);
        mysqli_stmt_execute($smt);
      }
      mysqli_stmt_close($smt);
    }else{
      $flage=0;
      die('Query cannot be prepares - insert');
    }
    if($flage){
      echo 1;
    }else{
      echo 0 ;
    }
  }

  if(isset($_POST['get_all_rooms'])){
    $res = select("SELECT * FROM `rooms` WHERE `removed`=?",[0],'i');
    $i=0;
    $data = "";
    while($row = mysqli_fetch_assoc($res)){
      if($row['status']==1){
        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>";
      }else{
        $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>in-active</button>";
      }

      $data .="
       <tr class='align-middle'>
        <td>$i</td>
        <td>$row[name]</td>
        <td>$row[area] sq.ft.</td>
        <td>
          <span class='badge rounded-pill bg-light text-dark'>
            Adult: $row[adult]
          </span><br>
          <span class='badge rounded-pill bg-light text-dark'>
            Children: $row[children]
          </span>
        </td>
        <td>₹ $row[price]</td>
        <td>$row[quantity]</td>
        <td>$status</td>
        <td>
            <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm ' data-bs-toggle='modal' data-bs-target='#edit-room'>
                              <i class='bi bi-pencil-square'></i>
            </button>
            <button type='button' onclick=\"room_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-image'>
                              <i class='bi bi-images'></i>
            </button>
            <button type='button' onclick='remove_room($row[id])'class='btn btn-danger shadow-none btn-sm'>
                              <i class='bi bi-trash'></i>
            </button>
        </td>
       </tr>
      ";
      $i++;
    }
    echo $data;
  }

  if(isset($_POST['toggle_status'])){
    $frm_data=filteration($_POST);
    $query="UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $values=[$frm_data['value'],$frm_data['toggle_status']];
    if(update($query,$values,'ii')){
      echo 1;
    }else{
      echo 0;
    }
  }

  if(isset($_POST['get_room'])){
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `rooms` WHERE `id`=?",[$frm_data['get_room']],'i');
    $res1 = select("SELECT * FROM `room_features` WHERE `room_id`=?",[$frm_data['get_room']],'i');
    $res2 = select("SELECT * FROM `room_facilities` WHERE `room_id`=?",[$frm_data['get_room']],'i');

    $roomdata = mysqli_fetch_assoc($res);
    $features = [];
    $facilities = [];

    if(mysqli_num_rows($res1)>0){
      while($row = mysqli_fetch_assoc($res1)){
        array_push($features,$row['features_id']);
      }
    }
    if(mysqli_num_rows($res2)>0){
      while($row = mysqli_fetch_assoc($res2)){
        array_push($facilities,$row['facilities_id']);
      }
    }
    $data = ["roomdata"=>$roomdata,"features"=>$features,"facilities"=>$facilities];
    $data = json_encode($data);
    echo $data;
  }

  if(isset($_POST['edit_room'])){

    $features=filteration(json_decode($_POST['features']));
    $facilities=filteration(json_decode($_POST['facilities']));
    $filt_data = filteration($_POST);
    $flage =0;
    $query="UPDATE `rooms` SET `name`=?,`area`=?,`quantity`=?,`price`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=? ";
    $value=[$filt_data['name'],$filt_data['area'],$filt_data['quantity'],$filt_data['price'],$filt_data['adult'],$filt_data['children'],$filt_data['description'],$filt_data['room_id']];
    
    if(update($query,$value,'siiiiisi')){
      $flage =1;
    }
    $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?",[$filt_data['room_id']],'i');
    $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?",[$filt_data['room_id']],'i');
    if(!($del_features && $del_facilities)){
      $flage =0;
    }
    $query1 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if($smt = mysqli_prepare($con,$query1)){
      foreach($facilities as $f){
        mysqli_stmt_bind_param($smt,'ii',$filt_data['room_id'],$f);
        mysqli_stmt_execute($smt);
      }
      $flage=1;
      mysqli_stmt_close($smt);
    }else{
      $flage=0;
      die('Query cannot be prepares - insert');
    }
    if($flage){
      echo 1;
    }else{
      echo 0 ;
    }
    
    $query2 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if($smt = mysqli_prepare($con,$query2)){
      foreach($features as $f){
        mysqli_stmt_bind_param($smt,'ii',$filt_data['room_id'],$f);
        mysqli_stmt_execute($smt);
      }
      $flage=1;
      mysqli_stmt_close($smt);
    }else{
      $flage=0;
      die('Query cannot be prepares - insert');
    }
    if($flage){
      echo 1;
    }else{
      echo 0 ;
    }
  }
  
  if(isset($_POST['add_image'])){
    $filt_data = filteration($_POST);
    $img_r = uploadImage($_FILES['image'],ROOMS_FOLDER);
    if($img_r == 'inv_img'){
      echo $img_r;
    }else if($img_r == 'inv_size'){
      echo $img_r;
    }else if($img_r == 'upd_failed'){
      echo $img_r;
    }else{
       
    $query ="INSERT INTO `room_images`( `room_id`, `image`) VALUES (?,?)";
    $values = [$filt_data['room_id'], $img_r];
    $res = insert($query,$values,"is");
    echo $res;
    }
  }

  if(isset($_POST['get_room_images'])){
    $filt_data = filteration($_POST);
    $res = select("SELECT * FROM `room_images` WHERE `room_id`=? ",[$filt_data['get_room_images']],'i');
    $path=ROOMS_IMG_PATH;
    
    while($row = mysqli_fetch_assoc($res)){
      if($row['thumb']==1){
        $thumb_btn="<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
      }else{
        $thumb_btn="<button onclick='thumb_image($row[sr_no],$row[room_id])' class='btn btn-secondary shadow-none'><i class='bi bi-check-lg'></i></button>";
      }
      echo<<<data
      <tr class='align-middle'>
      <td><img src='$path$row[image]' class='img-fluid'></td>
      <td>$thumb_btn</td>
      <td><button onclick='remove_image($row[sr_no],$row[room_id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i></button></td>
      </tr>
      data;
    }
  }

  if(isset($_POST['remove_image'])){
    $filt_data = filteration($_POST);
    $values = [$filt_data['image_id'],$filt_data['room_id']];
    $prep_query = "SELECT * FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
    $res = select($prep_query,$values,'ii');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],ROOMS_FOLDER)){
      $query = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
      $res = delete($query,$values,'ii');
      echo $res;
    }else{
      echo 0;
    }
  }

  if(isset($_POST['thumb_image'])){
    $filt_data = filteration($_POST);
    $query1="UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
    $value=[0,$filt_data['room_id']];
    $pre_res= update($query1,$value,'ii');

    $query2="UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
    $values=[1,$filt_data['image_id'],$filt_data['room_id']];
    $res= update($query2,$values,'iii');

    echo $res;
  }

  if(isset($_POST['remove_room'])){
    $filt_data = filteration($_POST);
    $res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$filt_data['room_id']],'i');
    while($row = mysqli_fetch_assoc($res1)){
      deleteImage($row['image'],ROOMS_FOLDER);
    }
    $res2 = delete("DELETE FROM `room_images` WHERE  `room_id`=?",[$filt_data['room_id']],'i');
    $res3 = delete("DELETE FROM `room_features` WHERE  `room_id`=?",[$filt_data['room_id']],'i');
    $res4 = update("UPDATE`rooms` SET `removed`=? WHERE  `id`=?",[1,$filt_data['room_id']],'ii');
    //fac

    if($res2 || $res3){
      echo 1;
    }else{
      echo 0;
    }
    echo $res;

  }

   
?>
