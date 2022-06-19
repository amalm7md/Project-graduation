<?php 
include 'header.php';

$ids = array();
$cls = array();
$teach = mysqli_query($conn,"SELECT * FROM teaching WHERE teacher_id = $user_id");
while($teachs = mysqli_fetch_assoc($teach)){
    array_push($ids,$teachs['subject']);
    array_push($cls,$teachs['class']);
}

if(isset($_POST['add'])){
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $class = $_POST['class'];
    $content = $_POST['content'];
    $now = date('Y/m/d');
    $time = date('H:m');
    $add = mysqli_query($conn,"INSERT INTO homeworks(teacher_id,subject,class,content,date) VALUES('$user_id','$subject','$class','$content','$date')");
    if($add){
        $event = mysqli_query($conn,"INSERT INTO events(title,content,date,ev_type) VALUES('واجب منزلي جديد','تم اضافة واجب منزلي','$date','2')");
        if($event){
            $logs = mysqli_query($conn,"INSERT INTO logs(user_id,content,date,time) VALUES('$user_id','تم اضافة واجب منزلي','$now','$time')");
            if($logs){
                $alert = '<div class="alert alert-success" role="alert">
                تم اضافة الواجب المنزلي بنجاح
            </div>';
            }else{
                $alert = '<div class="alert alert-danger" role="alert">
                لم يتم اضافة الواجب المنزلي! هناك خلل ما
            </div>';
            }
        }else{
            $alert = '<div class="alert alert-danger" role="alert">
            لم يتم اضافة الواجب المنزلي! هناك خلل ما
        </div>';
        }
    }else{
        $alert = '<div class="alert alert-danger" role="alert">
        لم يتم اضافة الواجب المنزلي! هناك خلل ما
    </div>';
    }
}
?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">انشاء واجب</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                    <?= (isset($alert))? $alert : ' ' ?>
                        <div class="card">
                            <div class="card-body card-form__body">
                                <form method="post" class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="control-label h6">عنوان الواجب:</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="control-label h6">التاريخ:</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="control-label h6">المادة:</label>
                                        <select name="subject" class="form-control">
                                            <?php 
                                            $qq = mysqli_query($conn,"SELECT * FROM subjects WHERE id IN (".implode(',', $ids).")");
                                            while($subjects = mysqli_fetch_assoc($qq)){ ?>
                                            <option value="<?= $subjects['id'] ?>"><?= $subjects['subject'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="control-label h6">الشعبة:</label>
                                        <select name="class" class="form-control">
                                            <?php 
                                            $cc = mysqli_query($conn,"SELECT * FROM classes WHERE id IN (".implode(',', $cls).")");
                                            while($class = mysqli_fetch_assoc($cc)){ ?>
                                            <option value="<?= $class['id'] ?>"><?= $class['grade'] ?>/<?= $class['class'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label class="control-label h6">تفاصيل الواجب:</label>
                                        <textarea name="content" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <button type="submit" name="add" class="btn btn-primary">اضافة</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php include 'footer.php'; ?>