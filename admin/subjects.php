<?php 
include 'header.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = $id"));
    $ssubject = $query['subject'];
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $add = mysqli_query($conn,"INSERT INTO subjects(subject) VALUES('$name')");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم اضافة المادة بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم اضافة المادة بنجاح</div>
        </div>';
    }
}

if(isset($_POST['update'])){
    $subject = $_POST['name'];
    $add = mysqli_query($conn,"UPDATE subjects SET subject='$subject' WHERE id = $id");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم تحديث المادة بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم تحديث المادة بنجاح</div>
        </div>';
    }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المواد</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-white d-flex align-items-center">
                                        <h4 class="card-header__title mb-0"><?= (isset($_GET['id']))? 'تعديل':'اضافة' ?> مادة</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>اسم المادة</label>
                                                <input name="name" value="<?= (isset($ssubject))? $ssubject:'' ?>" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input name="<?= (isset($_GET['id']))? 'update':'add' ?>" type="submit" value="<?= (isset($_GET['id']))? 'تعديل':'اضافة' ?>" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $query = mysqli_query($conn,"SELECT * FROM subjects");
                                                $no = 1;
                                                while($subjects = mysqli_fetch_assoc($query)){
                                                ?>
                                              <tr>
                                                <th scope="row"><?= $no; ?></th>
                                                <td><?= $subjects['subject'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="subjects.php?id=<?= $subjects['id'] ?>">تعديل</a>
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
<?php include 'footer.php' ?>