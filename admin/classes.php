<?php 
include 'header.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = $id"));
    $ggrade = $query['grade'];
    $cclass = $query['class'];
}


if(isset($_POST['add'])){
    $grade = $_POST['grade'];
    $class = $_POST['class'];
    $add = mysqli_query($conn,"INSERT INTO classes(grade,class) VALUES('$grade','$class')");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم اضافة الشعبة بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم اضافة الشعبة بنجاح</div>
        </div>';
    }
}

if(isset($_POST['update'])){
    $grade = $_POST['grade'];
    $class = $_POST['class'];
    $add = mysqli_query($conn,"UPDATE classes SET grade='$grade',class='$class' WHERE id = $id");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم تحديث الشعبة بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم تحديث الشعبة بنجاح</div>
        </div>';
    }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الشعب</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-white d-flex align-items-center">
                                        <h4 class="card-header__title mb-0"><?= (isset($_GET['id']))? 'تعديل':'اضافة' ?> شعبة</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>المرحلة</label>
                                                <input name="grade" value="<?= (isset($ggrade))? $ggrade:'' ?>" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>رقم الشعبة</label>
                                                <input name="class" value="<?= (isset($cclass))? $cclass:'' ?>" type="text" class="form-control">
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
                                                <th scope="col">المرحلة</th>
                                                <th scope="col">رقم الشعبة</th>
                                                <th scope="col">عدد الطلاب</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM classes");
                                                while($cls = mysqli_fetch_assoc($query)){
                                                    $id = $cls['id'];
                                                    $students = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students WHERE class= $id"));
                                                ?>
                                                <tr>
                                                <th scope="row">1</th>
                                                <td><?= $cls['grade'] ?></td>                                                
                                                <td><?= $cls['class'] ?></td>
                                                <td><?= $students ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="classes.php?id=<?= $cls['id'] ?>">تعديل</a>
                                                    </div>
                                                </td>
                                              </tr>
                                              <?php } ?>
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