<?php 
include 'header.php';

$tteacher_id = 0;
$cclass = 0;
$ssubject = 0;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teaching WHERE id = $id"));
    $tteacher_id = $query['teacher_id'];
    $cclass = $query['class'];
    $ssubject = $query['subject'];
}


if(isset($_POST['add'])){
    $teacher = $_POST['teacher'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $add = mysqli_query($conn,"INSERT INTO teaching(teacher_id,class,subject) VALUES('$teacher','$class','$subject')");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم اضافة التدريس بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم اضافة التدريس بنجاح</div>
        </div>';
    }
}

if(isset($_POST['update'])){
    $teacher = $_POST['teacher'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $add = mysqli_query($conn,"UPDATE teaching SET teacher_id='$teacher',class='$class',subject='$subject' WHERE id = $id");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم تحديث التدريس بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم تحديث التدريس بنجاح</div>
        </div>';
    }
}


?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">التدريس</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-white d-flex align-items-center">
                                        <h4 class="card-header__title mb-0"><?= (isset($_GET['id']))? 'تعديل':'اضافة' ?> تدريس</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>المدرس</label>
                                                <select name="teacher" class="form-control" id="">
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM users WHERE usertype = 1");
                                                    while($tchr = mysqli_fetch_assoc($query)){
                                                        $id = $tchr['id'];
                                                        $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $id")); 
                                                    ?>
                                                    <option value="<?= $tchr['id'] ?>" <?= ($tteacher_id == $tchr['id'])? 'selected' :'' ?>><?= $teacher['fullname'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>الشعبة</label>
                                                <select name="class" class="form-control" id="">
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM classes");
                                                    while($cls = mysqli_fetch_assoc($query)){
                                                    ?>
                                                    <option value="<?= $cls['id'] ?>" <?= ($cclass == $cls['id'])? 'selected' :'' ?>><?= $cls['grade'] ?>/<?= $cls['class'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>المادة</label>
                                                <select name="subject" class="form-control" id="">
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM subjects");
                                                    while($sbj = mysqli_fetch_assoc($query)){
                                                    ?>
                                                    <option value="<?= $sbj['id'] ?>" <?= ($ssubject == $sbj['id'])? 'selected' :'' ?>><?= $sbj['subject'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input name="<?= (isset($_GET['id']))? 'update':'add' ?>" type="submit" value="<?= (isset($_GET['id']))? 'تعديل':'اضافة' ?>" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">المدرس</th>
                                                <th scope="col">الشعبة</th>
                                                <th scope="col">المادة</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM teaching");
                                                $no = 1;
                                                while($teaching = mysqli_fetch_assoc($query)){
                                                    $teacher_id = $teaching['teacher_id'];
                                                    $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $teacher_id"));
                                                    $class_id = $teaching['class'];
                                                    $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = '$class_id'"));
                                                    $subject_id = $teaching['subject'];
                                                    $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = '$subject_id'"));
                                                ?>
                                                <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $teacher['fullname'] ?></td>                                                
                                                <td><?= $class['grade'] ?>/<?= $class['class'] ?></td>
                                                <td><?= $subject['subject'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="teaching.php?id=<?= $teaching['id'] ?>">تعديل</a>
                                                    </div>
                                                </td>
                                              </tr>
                                              <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // END drawer-layout__content -->
<?php include 'footer.php' ?>