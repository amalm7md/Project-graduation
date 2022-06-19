<?php
include 'header.php';

$sqlq = "SELECT * FROM options LIMIT 1";
$resul = mysqli_query($conn, $sqlq);
$options = mysqli_fetch_assoc($resul);
$id = $options['id'];
$sitename = $options['site_name'];
$logo = $options['site_logo'];
$email = $options['site_email'];
$phone = $options['site_phone'];

if(isset($_POST['update'])) {
    $new_name = htmlspecialchars($_POST['name']);
    $new_phone = htmlspecialchars($_POST['phone']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_logo = $_FILES['logo'];
    if($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0){
        $ext1 = pathinfo($new_logo['name'], PATHINFO_EXTENSION);
        $x = array('png', 'jpg', 'jpeg', 'gif');
        if( in_array($ext1, $x) ) {
            $newimgName = 'logo_'.time().".".$ext1;
            move_uploaded_file($new_logo['tmp_name'], '../images/logo/'.$newimgName);
            $newsqll = "UPDATE options SET site_name='$new_name', site_logo='$newimgName', site_email='$new_email', site_phone='$new_phone' WHERE id=$id";
            if(mysqli_query($conn, $newsqll)) {
                $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث بيانات الموقع بنجاح</div>
                </div>';
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث بيانات الموقع بنجاح</div>
                </div>';
            }
        } else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">تأكد من نوع الصورة المضافة</div>
            </div>';
        }
    }else{
        $newsqll = "UPDATE options SET site_name='$new_name', site_email='$new_email', site_phone='$new_phone' WHERE id=$id";
        if(mysqli_query($conn, $newsqll)) {
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث بيانات الموقع بنجاح</div>
                </div>';
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث بيانات الموقع بنجاح</div>
                </div>';
        }
    }
}

if(isset($_POST['update_pass'])) {
    $old = $_POST['old'];
    $old = sha1($old);
    $new = $_POST['new'];
    $new = sha1($new);
    $getadmin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE usertype = 0"));
    $oldpass = $getadmin['password'];
    if($oldpass == $old){
        $update = mysqli_query($conn,"UPDATE users SET password='$new' WHERE usertype=0");
        if($update){
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
            <div class="text-body">تم تحديث بيانات كلمة المرور بنجاح</div>
            </div>';
        }else{
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم تحديث بيانات كلمة المرور بنجاح</div>
            </div>';
        }
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">تحقق من كلمة المرور القديمة</div>
            </div>';
    }
}
?>

<div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">اعدادات الموقع العامة</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>تحديث الاعدادات</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" method="post" enctype="multipart/form-data">
                                            <div class="col-md-6 form-group">
                                                <label>اسم الموقع</label>
                                                <input name="name" value="<?= $sitename ?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>البريد الالكتروني</label>
                                                <input name="email" value="<?= $email ?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>رقم الجوال</label>
                                                <input name="phone" value="<?= $phone ?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>لوجو الموقع</label>
                                                <input name="logo" type="file" class="form-control">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input name="update" type="submit" value="تحديث" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3>تحديث كلمة المرور</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" method="post" enctype="multipart/form-data">
                                            <div class="col-md-6 form-group">
                                                <label>كلمة المرور القديمة</label>
                                                <input name="old" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>كلمة المرور الجديدة</label>
                                                <input name="new" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input name="update_pass" type="submit" value="تحديث" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php include 'footer.php' ?>