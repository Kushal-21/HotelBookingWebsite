<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $setting_res['site_title'] ?>-Rooms</title>
</head>

<body class="bg-ligth">
    <!--including header.php file-->
    <?php require('include/header.php');

        $checkin_default = '';
        $checkout_default = '';
        $adult_default = '';
        $children_default = '';
        if (isset($_GET['check_availability'])) {
            $frm_data = filteration($_GET);
            $checkin_default = $frm_data['checkin'];
            $checkout_default = $frm_data['checkout'];
            $adult_default = $frm_data['adult'];
            $children_default = $frm_data['children'];
        }
    ?>

    <!--rooms section-->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>
    <!--filter & cards section-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex justify-content-between align-items-center" style="font-weight: 500;">
                                    <span>Check Availability</span>
                                    <button id="chk_ava_btn" onclick="chk_ava_clear()" class="btn btn-sm shadow-none text-secondary d-none">Reset</button>
                                </h5>
                                <label class="form-label">Check-in</label>
                                <input class="form-control shadow-none mb-3" value="<?php echo $checkin_default ?>" id="checkin" onchange="chk_ava_filter()" type="date">
                                <label class="form-label">Check-out</label>
                                <input class="form-control shadow-none" value="<?php echo $checkout_default ?>" id="checkout" onchange="chk_ava_filter()" type="date">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex justify-content-between align-items-center" style="font-weight: 500;">
                                    <span>Facilities</span>
                                    <button id="facility_btn" onclick="facility_clear()" class="btn btn-sm shadow-none text-secondary d-none">Reset</button>
                                </h5>
                                <?php
                                    $facility_query = selectAll('facilities');
                                    while ($row = mysqli_fetch_assoc($facility_query)) {
                                        echo <<<fac
                                        <div class="mb-2">
                                        <input type="checkbox" onclick="fetch_rooms()" id="$row[id]" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1">
                                        <label class="form-check-label" for="$row[id]">$row[name]</label>
                                        </div>
                                        fac;
                                    }
                                ?>
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex justify-content-between align-items-center" style="font-weight: 500;">
                                    <span>Guetsts</span>
                                    <button id="guest_btn" onclick="guest_clear()" class="btn btn-sm shadow-none text-secondary d-none">Reset</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label mb-2">Adults</label>
                                        <input type="number" min="1" value="<?php echo $adult_default ?>" id="adult" oninput="guest_filter()" class="form-control shadow-none ">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label ">Children</label>
                                        <input type="number" min="1" value="<?php echo $children_default ?>" id="children" oninput="guest_filter()" class="form-control shadow-none">
                                    </div>
                                </div>

                            </div>
                        </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
                
            </div>
        </div>
    </div>

    <script>
        let rooms_data = document.getElementById('rooms-data');
        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let chk_ava_btn = document.getElementById('chk_ava_btn');
        let guest_btn = document.getElementById('guest_btn');
        let adult = document.getElementById('adult');
        let children = document.getElementById('children');
        let facility_btn = document.getElementById('facility_btn');

        function fetch_rooms() {

            let chk_ava = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });
            let guests = JSON.stringify({
                adult: adult.value,
                children: children.value
            });

            let facilities_list={"facilities":[]};
            let get_faci = document.querySelectorAll('[name="facilities"]:checked');
            if(get_faci.length>0){
                get_faci.forEach((facility)=>{
                    facilities_list.facilities.push(facility.value);
                });
                facility_btn.classList.remove('d-none');
            }else{
                facility_btn.classList.add('d-none');
            }
            facilities_list=JSON.stringify(facilities_list);

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_ava=" + chk_ava + "&guests=" + guests+"&facilities_list="+facilities_list, true);
            xhr.onprogress = function() {
                rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
                <span class="visually-hidden">Loading...</span>
               </div>`
            }
            xhr.onload = function() {
                rooms_data.innerHTML = this.responseText;
            }
            xhr.send();
        }

        function chk_ava_filter() {
            if (checkin.value != '' && checkout.value != '') {
                fetch_rooms();
                chk_ava_btn.classList.remove('d-none');
            }
        }

        function chk_ava_clear() {
            checkin.value = '';
            checkout.value = '';
            chk_ava_btn.classList.add('d-none');
            fetch_rooms();
        }

        function guest_filter() {
            if (adult.value > 0 || children.value > 0) {
                fetch_rooms();
                guest_btn.classList.remove('d-none');
            }
        }

        function guest_clear() {
            adult.value = '';
            children.value = '';
            guest_btn.classList.add('d-none');
            fetch_rooms();

        }

        function facility_clear(){
            let get_faci = document.querySelectorAll('[name="facilities"]:checked');
            get_faci.forEach((facility)=>{
                facility.checked=false;
            });
            facility_btn.classList.add('d-none'); 
            fetch_rooms();
        }


        window.onload = function() {
            fetch_rooms();
        }
    </script>



    <!--including footer.php file-->
    <?php require('include/footer.php'); ?>

</body>

</html>