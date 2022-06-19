<?php 
include 'header.php';

if(isset($_POST['add'])){
    $url_name = $_POST['url_name'];
    $url = $_POST['url'];
    $teaching_id = $_POST['teaching_id'];
    $add = mysqli_query($conn,"INSERT INTO urls(url_name,url,teaching_id) VALUES('$url_name','$url','$teaching_id')");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم اضافة الرابط بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم اضافة الرابط بنجاح</div>
        </div>';
    }
}
$editteaching_id = 0;

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $get_library = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM urls WHERE id = $id"));
    $editurl_name = $get_library['url_name'];
    $editurl = $get_library['url'];
    $editteaching_id = $get_library['teaching_id'];
}
if(isset($_POST['edit'])){
    $url_name = $_POST['url_name'];
    $url = $_POST['url'];
    $teaching_id = $_POST['teaching_id'];
    $add = mysqli_query($conn,"UPDATE urls SET url_name='$url_name',url='$url',teaching_id='$teaching_id' WHERE id = $id");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم تحديث الرابط بنجاح</div>
        </div>';
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم تحديث الرابط بنجاح</div>
        </div>';
    }
}
?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المكتبة</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-white d-flex align-items-center">
                                        <h4 class="card-header__title mb-0">اضافة رابط</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>عنوان الرابط</label>
                                                <input class="form-control" type="text" name="url_name" value="<?= (isset($editurl_name))? $editurl_name : ''; ?>" Required>
                                            </div>
                                            <div class="form-group">
                                                <label>الشعبة</label>
                                                <select name="teaching_id" class="form-control" Required>
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM teaching WHERE teacher_id = $user_id");
                                                    while($cls = mysqli_fetch_assoc($query)){
                                                        $class_id = $cls['class'];
                                                        $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = $class_id"));
                                                    ?>
                                                    <option value="<?= $class['id'] ?>" <?= ($editteaching_id == $class['id'])? 'selected':'' ?>><?= $class['grade'] ?>/<?= $class['class'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>الرابط</label>
                                                <input class="form-control" type="text" name="url" value="<?= (isset($editurl))? $editurl : ''; ?>" Required>
                                            </div>
                                            <div class="form-group">
                                                <?php if(isset($_GET['edit'])){ ?>
                                                    <input name="edit" type="submit" value="تحديث" class="btn btn-primary">
                                                <?php }else{ ?>
                                                    <input name="add" type="submit" value="اضافة" class="btn btn-primary">
                                                <?php } ?>
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
                                                <th scope="col">اسم الرابط</th>
                                                <th scope="col">الشعبة</th>
                                                <th scope="col">الرابط</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM urls");
                                                $no = 1;
                                                while($teaching = mysqli_fetch_assoc($query)){
                                                    $class_id = $teaching['teaching_id'];
                                                    $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = '$class_id'"));
                                                ?>
                                                <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $teaching['url_name'] ?></td>                                                
                                                <td><?= $class['grade'] ?>/<?= $class['class'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="<?= $teaching['url'] ?>" target="_blank">عرض</a>
                                                        <a class="btn btn-secondary" href="library.php?edit=<?= $teaching['id'] ?>">تعديل</a>
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