<?php 
include 'header.php';

$cclass = 0;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = $id"));
    $nname = $query['fullname'];
    $eemail = $query['email'];
    $pphone = $query['phone'];
    $aaddress = $query['address'];
    $cclass = $query['class'];
}

if(isset($_POST['add'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $class = $_POST['class'];
    $prefix = "std_";
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
            $imgName = 'std_'.time().".".$ext;
            move_uploaded_file($image['tmp_name'], '../images/students/'.$imgName);
            $add = mysqli_query($conn, "INSERT INTO users(username,password,usertype) VALUES('$username','$password','2')");
            if($add){
                $student_id = mysqli_insert_id($conn);
                $add_student = mysqli_query($conn, "INSERT INTO students(user_id,fullname,image,phone,email,address,class) VALUES('$student_id','$name','$imgName','$phone','$email','$address','$class')");
                if($add_student) {
                    $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                    <div class="text-body">تم اضافة الطالب بنجاح</div>
                    </div>';
                }else {
                    $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                    <div class="text-body">لم يتم اضافة الطالب بنجاح</div>
                    </div>';
                }
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم اضافة الطالب بنجاح</div>
                </div>';
            }
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم اضافة الطالب يرجى التحقق من نوع الصورة</div>
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
    $class = $_POST['class'];
    $prefix = "std_";
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
            $imgName = 'std_'.time().".".$ext;
            move_uploaded_file($image['tmp_name'], '../images/students/'.$imgName);
            $update_student = mysqli_query($conn, "UPDATE students SET fullname='$name',image='$imgName',phone='$phone',email='$email',address='$address',class='$class' WHERE user_id = $id");
            if($update_student) {
                $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                <div class="text-body">تم تحديث الطالب بنجاح</div>
                </div>';
            }else {
                $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم تحديث الطالب بنجاح</div>
                </div>';
            }
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم تحديث الطالب يرجى التحقق من نوع الصورة</div>
            </div>';
        }
    }else{
        $update_student = mysqli_query($conn, "UPDATE students SET fullname='$name',phone='$phone',email='$email',address='$address',class='$class' WHERE user_id = $id");
        if($update_student) {
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
            <div class="text-body">تم تحديث الطالب بنجاح</div>
            </div>';
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم تحديث الطالب بنجاح</div>
            </div>';
        }
    }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0"><?= (isset($_GET['id']))? 'تعديل':'اضافة' ?> طالب</h1>
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
                                                <label>اسم الطالب</label>
                                                <input name="fullname" value="<?= (isset($nname))? $nname : ''?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>صورة الطالب</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>البريد الالكتروني</label>
                                                <input name="email" value="<?= (isset($eemail))? $eemail : ''?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>رقم الجوال</label>
                                                <input name="phone" value="<?= (isset($pphone))? $pphone : ''?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>العنوان</label>
                                                <input name="address" value="<?= (isset($aaddress))? $aaddress : ''?>" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>الفصل</label>
                                                <select name="class" class="form-control" id="">
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM classes");
                                                    while($cls = mysqli_fetch_assoc($query)){
                                                    ?>
                                                    <option value="<?= $cls['id'] ?>" <?= ($cclass == $cls['id'])? 'selected' : ''?>><?= $cls['grade'] ?>/<?= $cls['class'] ?></option>
                                                    <?php } ?>
                                                </select>
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
<?php include 'footer.php' ?>