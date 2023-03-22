<!--connecting db_config file-->
<?php require('include/db_config.php'); 
  session_start(); /*start the session*/
  session_destroy(); /*destroy the session*/
  redirect('admin_hotel.php'); /*redirect to the admin login page*/
?>


