<?php
require('../include/db_config.php');
adminLogin();



if (isset($_POST['add_feature'])) {
  $filt_data = filteration($_POST);
  $query = "INSERT INTO `features`(`name`) VALUES (?)";
  $values = [$filt_data['name']];
  $res = insert($query, $values, "s");
  echo $res;
}
if (isset($_POST['get_features'])) {
  $res = selectAll('features');
  $i = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
      <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>
          <button type="button" onclick="remove_feature($row[id])" class="btn btn-sm btn-danger shadow-none">
            <i class="bi bi-trash"></i>  Delete
           </button>
        </td>
      </tr>
    data;
    $i++;
  }
}
if (isset($_POST['remove_feature'])) {
  $filt_data = filteration($_POST);
  $values = [$filt_data['remove_feature']];
  $check_query = select('SELECT * FROM `room_features` WHERE `features_id`=?',[$filt_data['remove_feature']],'i');
  if(mysqli_num_rows($check_query)==0){
    $query = "DELETE FROM `features` WHERE `id`=?";
    $res = delete($query, $values, 'i');
    echo $res;
  }else{
    echo 'room_added';
  }
  
}


if(isset($_POST['add_facilities'])){
  $filt_data = filteration($_POST);
  $img_r = uploadSvgImage($_FILES['icon'],FACILITIES_FOLDER);
  if($img_r == 'inv_img'){
    echo $img_r;
  }else if($img_r == 'inv_size'){
    echo $img_r;
  }else if($img_r == 'upd_failed'){
    echo $img_r;
  }else{
     
  $query = "INSERT INTO `facilities`(`icon`, `name`, `description`) VALUES (?,?,?)";
  $values = [$img_r,$filt_data['name'],$filt_data['description']];
  $res = insert($query,$values,'sss');
  echo $res;
  }
}
if (isset($_POST['get_facilities'])) {
  $res = selectAll('facilities');
  $i = 1;
  $path= FACILITIES_IMG_PATH;
  while ($row = mysqli_fetch_assoc($res)) {
    echo <<<data
      <tr class="align-middle">
        <td>$i</td>
        <td><img src="$path$row[icon]" width="100px"></td>
        <td>$row[name]</td>
        <td>$row[description]</td>
        <td>
          <button type="button" onclick="remove_facilities($row[id])" class="btn btn-sm btn-danger shadow-none">
            <i class="bi bi-trash"></i> Delete
           </button>
        </td>
      </tr>
    data;
    $i++;
  }
}
if(isset($_POST['remove_facilities'])) {
  $filt_data = filteration($_POST);
  $values = [$filt_data['remove_facilities']];
    $prep_query = "SELECT * FROM `facilities` WHERE `id`=?";
    $res = select($prep_query,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['icon'],FACILITIES_FOLDER)){
      $query = "DELETE FROM `facilities` WHERE `id`=?";
      $res = delete($query, $values, 'i');
      echo $res;
    }else{
      echo 0;
    }

}
 ?>