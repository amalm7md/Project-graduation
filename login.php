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

$option = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM options LIMIT 1"));

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = sha1($password);
    $check_user = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_user) > 0){
        $data = mysqli_fetch_assoc($check_user);
        if($data['password'] == $password){
            if($data['usertype'] == 0){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $data['id'];
                $_SESSION['usertype'] = 0;
                header('Location: admin');
            }elseif($data['usertype'] == 1){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $data['id'];
                $_SESSION['usertype'] = 1;
                header('Location: teacher');
            }elseif($data['usertype'] == 2){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $data['id'];
                $_SESSION['usertype'] = 2;
                header('Location: student');
            }
        }else{
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">يرجى التحقق من كلمة المرور</div>
        </div>';
        }
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">يرجى التحقق من اسم المستخدم</div>
    </div>';
    }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>دخول</title>
    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">
    <!-- App CSS -->
    <link type="text/css" href="admin/assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/app.rtl.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link type="text/css" href="admin/assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/vendor-material-icons.rtl.css" rel="stylesheet">
    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="admin/assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="admin/assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">
</head>

<body>
    <div class="container h-100 d-flex">
        <div class="card card-body p-0 m-auto">
            <?= (isset($alert))? $alert:'' ?>
            <div class="row w-100 p-0 m-0">
                <div class="col-md-6 p-5">
                    <form method="post" novalidate>
                        <div class="form-group">
                            <label class="text-label" for="email_2">اسم المستخدم:</label>
                            <div class="input-group input-group-merge">
                                <input id="email_2" name="username" type="text" required="" class="form-control form-control-prepended" placeholder="john@doe.com">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-label" for="password_2">كلمة المرور:</label>
                            <div class="input-group input-group-merge">
                                <input id="password_2" name="password" type="password" required="" class="form-control form-control-prepended" placeholder="كلمة المرور">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fa fa-key"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1">
                            <button class="btn btn-block btn-primary" name="login" type="submit">دخول</button>
                        </div>
                        <div class="form-group text-center mb-0">
                            <a href="forget.php">نسيت كلمة المرور؟</a> <br>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 bg-primary">
                    <div class="d-flex justify-content-center h-100 m-auto">
                        <a href="index.php" class="text-center m-auto">
                            <!-- LOGO -->
                            <?php if(isset($option['site_logo'])){ ?>
                            <img width="150" src="images/logo/<?= $option['site_logo'] ?>">
                            <?php }else{ ?>
                            <h3><?= $option['site_name'] ?></h3>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </div>
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