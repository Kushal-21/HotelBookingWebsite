    <!--footer section-->
    <div class="container-fluid bg-white rounded shadow mt-5">
        <div class="row ">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $setting_res['site_title'] ?></h3>
                <p><?php echo $setting_res['site_about'] ?></p>
            </div>
            <div class="col-lg-4  p-4">
                <h3 class="mb-3">Links</h3>
                <a href="hotel.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
                <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
                <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilitiess</a><br>
                <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a><br>
                <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
            </div>
            <div class="col-lg-4 p-4">
                <h3 class="mb-3">Follow us</h3>
                <?php
                if ($contact_res['tw'] != '') {
                    echo <<<data
                       <a href="$contact_res[tw]" class="d-inline-block text-dark text-decoration-none mb-2"><i class="bi bi-twitter me-1"></i> Twitter</a><br>
                    data;
                }
                ?>
                <a href="<?php echo $contact_res['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2"><i class="bi bi-facebook me-1"></i> Facebook</a><br>
                <a href="<?php echo $contact_res['ins'] ?>" class="d-inline-block text-dark text-decoration-none "><i class="bi bi-instagram me-1"></i> Instagram</a><br>
            </div>

        </div>
    </div>

    <h6 class="text-center bg-dark text-white p-3 m-0">Designed and developed by <?php echo $setting_res['site_title'] ?>@All Right Reserved</h6>

    <?php require('admin/include/script.php'); ?>
    <!-- script to add active class dynamically-->
    <script>
        function alert(type, msg, position = 'body') {
            let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
            let element = document.createElement('div');
            element.innerHTML = `
                <div class="alert ${bs_class} alert-dismissible fade show " role="alert">
                   <strong class="me-3">${msg}</strong>
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div>
            `;
            if (position == 'body') {

                document.body.append(element); //append this element in the html body
                element.classList.add('custom-alert');
            } else {
                document.getElementById(position).appendChild(element);
            }
            setTimeout(remAlert, 3000);
        }

        function remAlert() {
            document.getElementsByClassName('alert')[0].remove();
        }

        function setActive() {
            let navbar = document.getElementById('nav-bar');
            let a_tags = navbar.getElementsByTagName('a');

            for (i = 0; i < a_tags.length; i++) {
                let file = a_tags[i].href.split('/').pop();
                let file_name = file.split('.')[0];

                if (document.location.href.indexOf(file_name) >= 0) {
                    a_tags[i].classList.add('active');
                }
            }
        }
        setActive();
    </script>