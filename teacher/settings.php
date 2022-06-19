<?php
include 'header.php';

$sqlq = "SELECT * FROM teachers WHERE user_id = $user_id";
$resul = mysqli_query($conn, $sqlq);
$options = mysqli_fetch_assoc($resul);
$name = $options['fullname'];
$image = $options['image'];
$email = $options['email'];
$phone = $options['phone'];
$address = $options['address'];

if(isset($_POST['update'])) {
    $new_phone = htmlspecialchars($_POST['phone']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_address = htmlspecialchars($_POST['address']);
    $new_logo = $_FILES['logo'];
    if($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0){
        $ext1 = pathinfo($new_logo['name'], PATHINFO_EXTENSION);
        $x = array('png', 'jpg', 'jpeg', 'gif');
        if( in_array($ext1, $x) ) {
            $newimgName = 'std_'.time().".".$ext1;
            move_uploaded_file($new_logo['tmp_name'], '../images/teachers/'.$newimgName);
            $newsqll = "UPDATE teachers SET image='$newimgName', phone='$new_phone', email='$new_email', address='$new_address' WHERE user_id=$user_id";
            if(mysqli_query($conn, $newsqll)) {
                $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث بيانات المدرس بنجاح</div>
                </div>';
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث بيانات المدرس بنجاح</div>
                </div>';
            }
        } else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">تأكد من نوع الصورة المضافة</div>
            </div>';
        }
    }else{
        $newsqll = "UPDATE teachers SET phone='$new_phone', email='$new_email', address='$new_address' WHERE user_id='$user_id'";
        if(mysqli_query($conn, $newsqll)) {
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث بيانات المدرس بنجاح</div>
                </div>';
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث بيانات المدرس بنجاح</div>
                </div>';
        }
    }
}

if(isset($_POST['update_pass'])) {
    $old = $_POST['old'];
    $old = sha1($old);
    $new = $_POST['new'];
    $new = sha1($new);
    $getadmin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id = $user_id"));
    $oldpass = $getadmin['password'];
    if($oldpass == $old){
        $update = mysqli_query($conn,"UPDATE users SET password='$new' WHERE id = $user_id");
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
                            <h1 class="m-lg-0">اعدادات الحساب العامة</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>تحديث الاعدادات</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row" method="post" enctype="multipart/form-data">
                                            <div class="col-md-6 form-group">
                                                <label>اسم المدرس</label>
                                                <input name="name" value="<?= $name ?>" type="text" class="form-control" disabled>
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
                                                <label>العنوان</label>
                                                <input name="address" value="<?= $address ?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>الصورة</label>
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
                            <div class="col-md-4">
                                <div>
                                    <img width="100%" src="../images/teachers/<?= $image ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php include 'footer.php' ?>