<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>
    <title><?php echo $setting_res['site_title'] ?>-Contact</title>
    <style>
        .custom-alert {
            position: fixed;
            top: 80px;
            right: 25px;
        }
    </style>
</head>

<body class="bg-ligth">
    <!--including header.php file-->
    <?php require('include/header.php'); ?>

    <!--contact section-->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos <br>iusto, repudiandae
            aliquid neque illum nostrum quis ea in commodi! Qui?
        </p>
    </div>

    <div class="container">
        <div class="row ">
            <div class="col-lg-6 col-md-6  px-4 mb-5">
                <div class="bg-white rounded shadow p-4 ">
                    <iframe class="w-100 rounded mb-4" src="<?php echo $contact_res['iframe'] ?>" height="320px" style="border:0;" loading="lazy"></iframe>
                    <a href="<?php echo $contact_res['gm'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2"><i class="bi bi-geo-alt-fill"></i>
                        <?php echo $contact_res['address'] ?>
                    </a>
                    <h5 class="mt-4">Call us</h5>
                    <a href="tel: +<?php echo $contact_res['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-drk"><i class="bi bi-telephone-fill"></i> +<?php echo $contact_res['pn1'] ?></a><br>
                    <?php
                    if ($contact_res['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_res[pn2]" class="d-inline-block  text-decoration-none text-drk"><i class="bi bi-telephone-fill"></i> +$contact_res[pn2]</a>
                        data;
                    }
                    ?>
                    <h5 class="mt-4">E-mail</h5>
                    <a href="mailto: <?php echo $contact_res['email'] ?>" class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-envelope-fill"></i> <?php echo $contact_res['email'] ?>
                    </a>
                    <h5 class="mt-4">Follow us</h5>
                    <?php
                    if ($contact_res['tw'] != '') {
                        echo <<<data
                              <a href="$contact_res[tw]" class="d-inline-block text-dark fs-5 me-2">
                                <i class="bi bi-twitter me-1"></i> 
                              </a>
                            data;
                    }
                    ?>
                    <a href="<?php echo $contact_res['fb'] ?>" class="d-inline-block  text-dark fs-5 me-2"><i class="bi bi-facebook me-1"></i></a>
                    <a href="<?php echo $contact_res['ins'] ?>" class="d-inline-block text-dark fs-5 "><i class="bi bi-instagram me-1"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6  px-4">
                <div class="bg-white rounded shadow p-4 ">
                    <form method="POST">
                        <h5>Send a message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Name</label>
                            <input type="text" name="name" required class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Email</label>
                            <input type="email" name="email" required class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Subject</label>
                            <input type="text" name="subject" required class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Message</label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                        <button type="submit" name="send" required class="btn text-white custom-bg mt-3">SEND</button>
                </div>
                </form>

            </div>
        </div>

    </div>
    </div>

    <?php
    if (isset($_POST['send'])) {
        $filt_data = filteration($_POST);
        $query = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $values = [$filt_data['name'], $filt_data['email'], $filt_data['subject'], $filt_data['message']];
        $res = insert($query, $values, 'ssss');
        if ($res == 1) {
            alert('success','Mail sent!');
        } else {
           alert('error','Server Down!');
        }
    }
    ?>

    <!--including footer.php file-->
    <?php require('include/footer.php'); ?>
    

</body>

</html>