<?php 
if(!isset($_GET['id'])){
    header('Location: homeworks.php');
}else{
    include 'header.php';
    $id = $_GET['id'];
    $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM homeworks WHERE id = $id"));
    $subject_id = $result['subject'];
    $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = $subject_id"));
}

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $date = date('Y/m/d');
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $x = array('doc', 'docm', 'docx', 'dot', 'dotx');
    if( in_array($ext, $x) ) {
        $fileName = $user_id.'_'.$id.".".$ext;
        move_uploaded_file($file['tmp_name'], '../homeworks/'.$fileName);
        $add = mysqli_query($conn, "INSERT INTO homework_answers(homework_id,student_id,filename,date) VALUES('$id','$user_id','$fileName','$date')");
        if($add){
            $alert = '<div class="alert alert-soft-success d-flex" role="alert">
                    <div class="text-body">تم اضافة الحل بنجاح</div>
                    </div>';
        }else {
            $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
            <div class="text-body">لم يتم اضافة الحل بنجاح</div>
            </div>';
        }
    }else {
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم اضافة الحل بنجاح</div>
        </div>';
    }
    
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">واجب منزلي</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : ' ' ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p><?= $subject['subject'] ?> - <?= $result['date'] ?></p>
                                        <hr>
                                        <p><?= $result['content'] ?></p>
                                        <hr>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="">تسليم الحل</label>
                                                <input type="file" class="form-control" name="file">
                                                <span>يتم ارفاق الحل في ملف وورد</span>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" name="submit">تسليم</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include 'footer.php' ?>