<?php 
session_start();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] == '0'){
        header('Location: admin');
    }elseif($_SESSION['usertype'] == '1'){
        header('Location: teacher');
    }elseif($_SESSION['usertype'] == '2'){
        header('Location: student');
    }
}
include "inc/db.php";

function send_email($email,$new){
    $subject = "كلمة المرور الجديدة";
    $message = "<b>كلمة المرور الجديدة الخاصة بك هي:</b>";
    $message .= "<h1>".$new."</h1>";
    $header = "From:admin@moodle.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    mail($email,$subject,$message,$header);
}

if(isset($_POST['forget'])){
    $username = $_POST['username'];
    $check_user = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_user) > 0){
        $data = mysqli_fetch_assoc($check_user);
        $id = $data['id'];
        if($data['usertype'] == 1){
            $get = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $id"));
        }elseif($data['usertype'] == 2){
            $get = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = $id"));
        }
        $email = $get['email'];
        $new = rand(0001,9999);
        $update = mysqli_query($conn,"UPDATE users SET password = '$new' WHERE id = $id");
        if($update){
            if(send_email($email,$new)){
                $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                    <div class="text-body">تم ارسال كلمة المرور الجديدة الى البريد الالكتروني</div>
                </div>';
            }else{
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                    <div class="text-body">هناك خلل ما! حاول مرة اخرى لاحقا</div>
                </div>';
            }
        }else{
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">هناك خلل ما! حاول مرة اخرى لاحقا</div>
            </div>';
        }
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">يرجى التحقق من اسم المستخدم</div>
    </div>';
    }
}
$option = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM options LIMIT 1"));

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>نسيت كلمة المرور</title>
    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">
    <!-- Perfect Scrollbar -->
    <link type="text/css" href="admin/assets/vendor/perfect-scrollbar.css" rel="stylesheet">
    <!-- App CSS -->
    <link type="text/css" href="admin/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/app.rtl.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link type="text/css" href="admin/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">
    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="admin/assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">
    <!-- ion Range Slider -->
    <link type="text/css" href="admin/assets/css/vendor-ion-rangeslider.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/vendor-ion-rangeslider.rtl.css" rel="stylesheet">
</head>

<body class="layout-login-centered-boxed">
    <div class="layout-login-centered-boxed__form">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-4 navbar-light">
            <a href="index.html" class="text-center text-light-gray mb-4">
                <!-- LOGO -->
                <?php if(isset($option['site_logo'])){ ?>
                <img width="100" src="images/logo/<?= $option['site_logo'] ?>">
                <?php }else{ ?>
                <h3><?= $option['site_name'] ?></h3>
                <?php } ?>
            </a>
        </div>
        <div class="card card-body">
            <?= (isset($alert))? $alert:'' ?>
            <form method="post" >
                <div class="form-group">
                    <label class="text-label" for="email_2">اسم المستخدم:</label>
                    <div class="input-group input-group-merge">
                        <input id="email_2" name="username" type="text" class="form-control form-control-prepended" Required>
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="far fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-1">
                    <button class="btn btn-block btn-primary" name="forget" type="submit">ارسال كلمة المرور الجديدة</button>
                </div>
                <div class="form-group text-center mb-0">
                    <a href="login.php">الرجوع لصفحة الدخول</a> <br>
                </div>
            </form>
        </div>
    </div>


    <!-- jQuery -->
    <script src="admin/assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="admin/assets/vendor/popper.min.js"></script>
    <script src="admin/assets/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="admin/assets/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="admin/assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="admin/assets/vendor/material-design-kit.js"></script>

    <!-- Range Slider -->
    <script src="admin/assets/vendor/ion.rangeSlider.min.js"></script>
    <script src="admin/assets/js/ion-rangeslider.js"></script>

    <!-- App -->
    <script src="admin/assets/js/toggle-check-all.js"></script>
    <script src="admin/assets/js/check-selected-row.js"></script>
    <script src="admin/assets/js/dropdown.js"></script>
    <script src="admin/assets/js/sidebar-mini.js"></script>
    <script src="admin/assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="admin/assets/js/app-settings.js"></script>




</body>

</html>