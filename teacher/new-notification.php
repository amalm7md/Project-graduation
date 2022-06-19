<?php 
include 'header.php';


if(isset($_POST['add'])) {
    $class = $_POST['class'];
    $type = 3;
    $content = $_POST['content'];
    $date = date('Y/m/d');
    $add = mysqli_query($conn, "INSERT INTO notifications(usertype,class,content,date) VALUES('$type','$class','$content','$date')");
    if($add){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم ارسال الاشعار بنجاح</div>
        </div>';
    }else {
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم ارسال الاشعار بنجاح</div>
        </div>';
    }
}
?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">ارسال اشعار</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="row" method="post">
                                            <div class="col-md-6 form-group">
                                                <label>الشعبة</label>
                                                <select name="class" class="form-control">
                                                    <?php
                                                    $query = mysqli_query($conn,"SELECT * FROM teaching WHERE teacher_id = '$user_id'");
                                                    while($results = mysqli_fetch_assoc($query)){
                                                        $class_id = $results['class'];
                                                        $get_class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = $class_id"));
                                                    ?>
                                                    <option value="<?= $get_class['id'] ?>"><?= $get_class['grade'] ?>/<?= $get_class['class'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>الاشعار</label>
                                                <input name="content" type="text" class="form-control" Required>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input name="add" type="submit" value="ارسال" class="btn btn-primary">
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
