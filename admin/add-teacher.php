<?php 
include 'header.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $id"));
    $nname = $query['fullname'];
    $eemail = $query['email'];
    $pphone = $query['phone'];
    $aaddress = $query['address'];
}

if(isset($_POST['add'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $prefix = "tch_";
    $password = $_POST['password'];
    $password = sha1($password);
    $true = 0;
    while($true == 0){
      $username = $prefix.rand(0001,9999);
      $check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'"));
      if($check == 0){
        $true = 1;
        $image = $_FILES['image'];
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $x = array('png', 'jpg', 'jpeg', 'gif');
        if( in_array($ext, $x) ) {
            $imgName = 'tch_'.time().".".$ext;
            move_uploaded_file($image['tmp_name'], '../images/teachers/'.$imgName);
            $add = mysqli_query($conn, "INSERT INTO users(username,password,usertype) VALUES('$username','$password','1')");
            if($add){
                $student_id = mysqli_insert_id($conn);
                $add_student = mysqli_query($conn, "INSERT INTO teachers(user_id,fullname,image,phone,email,address) VALUES('$student_id','$name','$imgName','$phone','$email','$address')");
                if($add_student) {
                    $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                    <div class="text-body">تم اضافة المدرس بنجاح</div>
                    </div>';
                }else {
                    $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                    <div class="text-body">لم يتم اضافة33 المدرس بنجاح</div>
                    </div>';
                }
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم اضافة44 المدرس بنجاح</div>
                </div>';
            }
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم اضافة المدرس يرجى التحقق من نوع الصورة</div>
            </div>';
        }
      }else{
        $true = 0;
      }
    }
}

if(isset($_POST['update'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $prefix = "tch_";
    $password = $_POST['password'];
    if(!empty($password)){
        $password = sha1($password);
        mysqli_query($conn, "UPDATE users SET password='$password' WHERE id=$id");
    }
    $image = $_FILES['image'];
    if($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0){
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $x = array('png', 'jpg', 'jpeg', 'gif');
        if( in_array($ext, $x) ) {
            $imgName = 'tch_'.time().".".$ext;
            move_uploaded_file($image['tmp_name'], '../images/teachers/'.$imgName);
            $update_student = mysqli_query($conn, "UPDATE teachers SET fullname='$name',image='$imgName',phone='$phone',email='$email',address='$address' WHERE user_id = $id");
            if($update_student) {
                $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث المدرس بنجاح</div>
                </div>';
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث المدرس بنجاح</div>
                </div>';
            }
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم تحديث المدرس يرجى التحقق من نوع الصورة</div>
            </div>';
        }
    }else{
        $update_student = mysqli_query($conn, "UPDATE teachers SET fullname='$name',phone='$phone',email='$email',address='$address' WHERE user_id = $id");
        if($update_student) {
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
            <div class="text-body">تم تحديث المدرس بنجاح</div>
            </div>';
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم تحديث المدرس بنجاح</div>
            </div>';
        }
    }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0"><?= (isset($_GET['id']))? 'تعديل':'اضافة' ?> مدرس</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="row" method="post" enctype="multipart/form-data">
                                            <div class="col-md-6 form-group">
                                                <label>اسم المدرس</label>
                                                <input name="fullname" value="<?= (isset($nname))? $nname : ''?>" type="text" class="form-control" Required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>صورة المدرس</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>البريد الالكتروني</label>
                                                <input name="email" value="<?= (isset($eemail))? $eemail : ''?>" type="text" class="form-control" Required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>رقم الجوال</label>
                                                <input name="phone" value="<?= (isset($pphone))? $pphone : ''?>" type="text" class="form-control" Required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>العنوان</label>
                                                <input name="address" value="<?= (isset($aaddress))? $aaddress : ''?>" type="text" class="form-control" Required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>كلمة المرور</label>
                                                <input name="password" type="text" class="form-control" <?= (isset($_GET['id']))?'':'Required' ?>>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input name="<?= (isset($_GET['id']))?'update':'add' ?>" type="submit" value="<?= (isset($_GET['id']))?'تعديل':'اضافة' ?>" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // END drawer-layout__content -->
<?php include 'footer.php' ?>
