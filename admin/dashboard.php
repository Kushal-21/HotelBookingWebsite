<!--connecting db_config file-->
<?php require('include/db_config.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login-Dashboard</title>
    <?php require('include/links.php'); ?>
</head>

<body class="bg-light">
    <!--conecting admin_header file-->
    <?php require('include/admin_header.php'); 
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));
    $room_count = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `rooms` WHERE `status`=1"));
    $feature_count = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `features`"));
    $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` FROM `user_queries` WHERE `seen`=0"));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 p-4 ms-auto overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Dashboard</h3>
                    <?php 
                    if($is_shutdown['shutdown']){
                        echo<<<data
                            <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown Mode is Active!</h6>
                        data;
                    }
                    ?>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="rooms.php" class="text-decoration-none">
                            <div class="card text-success text-center p-3">
                                <h6>Rooms</h6>
                                <h1 class="mt-2 mb-0"><?php echo $room_count['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-info text-center p-3">
                                <h6>User's Query</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="features_faci.php" class="text-decoration-none">
                            <div class="card text-info text-center p-3">
                                <h6>Features</h6>
                                <h1 class="mt-2 mb-0"><?php echo $feature_count['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-warning text-center p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>Booking Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto">
                        <option value="1">Past 30 days</option>
                        <option value="2">Past 90 days</option>
                        <option value="3">Past 1 year</option>
                        <option value="4">All times</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-primary text-center p-3">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0">20</h1>
                            <h4 class="mt-2 mb-0">₹ 32,100</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-warning text-center p-3">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0">15</h1>
                            <h4 class="mt-2 mb-0">₹ 21,900</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-danger text-center p-3">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            <h4 class="mt-2 mb-0">₹ 10,200</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>User's Queries, Ratings and Reviews Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto">
                        <option value="1">Past 30 days</option>
                        <option value="2">Past 90 days</option>
                        <option value="3">Past 1 year</option>
                        <option value="4">All times</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-success text-center p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0">50</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-info text-center p-3">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-warning text-center p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0">1500+</h1>
                        </div>
                    </div>
                </div>
                <h5>Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-success text-center p-3">
                            <h6>Total </h6>
                            <h1 class="mt-2 mb-0">100+</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-info text-center p-3">
                            <h6>Active </h6>
                            <h1 class="mt-2 mb-0">80+</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-warning text-center p-3">
                            <h6>Inactive </h6>
                            <h1 class="mt-2 mb-0">10+</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-danger text-center p-3">
                            <h6>Unverified </h6>
                            <h1 class="mt-2 mb-0">10+</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php require('include/script.php'); ?>
</body>

</html>