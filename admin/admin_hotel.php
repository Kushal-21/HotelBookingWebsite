<!--connecting db_config file-->
<?php require('include/db_config.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('include/links.php'); ?>
</head>

<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input type="text" name="admin_name" required class="form-control text-center shadow-none" placeholder="Admin Name">
                </div>
                <div class="mb-4">
                    <input type="password" name="admin_pass" required class="form-control text-center shadow-none mb-2" placeholder="Password">
                </div>
                <button type="submit" name="admin_login" class="btn text-white custom-bg shadow-none">Login</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['admin_login'])) {
        $filt_data = filteration($_POST);
        /*store the filtered data in filt_data varialbel*/
        /* Select query*/
        $query = "SELECT * FROM `admin_table` WHERE `admin_name`=? AND `admin_pass`=?";
        /*storing the values*/
        $values = [$filt_data['admin_name'], $filt_data['admin_pass']];
        /*storing the result of query */
        $res = select($query, $values, "ss");
        if ($res->num_rows == 1) { /*if num of rows is 1*/
            $row = mysqli_fetch_assoc($res);  /*fetching the data of res and store in row*/

            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['sr_no'];
            redirect('dashboard.php');  /*when session will start it will redirect to dashboard*/
        } else {
            alert('error', 'Login failed - Invalid Credentials!');
        }
    }
    ?>


   <?php require('include/script.php'); ?>
</body>

</html>