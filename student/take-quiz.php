<?php 
if(!isset($_GET['id'])){
    header('Location: quizes.php');
}else{
    include '../inc/db.php'; 
    $id = $_GET['id'];
    $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM quizes WHERE id = $id"));
    $date = $result['date'];
    $time = $result['time'];
    $endtime = date('H:i:s',strtotime("+90 minutes", strtotime($time)));

    $teacher_id = $result['teacher_id'];
    $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $teacher_id"));
    $subject_id = $result['subject'];
    $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = $subject_id"));
    $class_id = $result['class'];
    $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = $class_id"));
    if($result['type'] == 1){
        $type = 'شهري';
    }elseif($result['type'] == 2){
        $type = 'نصفي';
    }elseif($result['type'] == 3){
        $type = 'نهائي';
    }
    $query = mysqli_query($conn,"SELECT * FROM questions WHERE quiz_id = $id");
    $num_of_questions = mysqli_num_rows($query);
    $correct = [];
    while($questions = mysqli_fetch_assoc($query)){ 
        array_push($correct,$questions['correct']);
    }
}
include 'header.php';

if(isset($_POST['submit'])){
    $date = date('Y-m-d');
    $answers = $_POST['answer'];
    $defferent = array_diff($answers,$correct);
    $num_of_correct = $num_of_questions - count($defferent);
    $mark = ($num_of_correct/$num_of_questions)*100;
    $aanswers  = implode(",", $answers);
    
    $add = mysqli_query($conn,"INSERT INTO quizes_answers(student_id,quiz_id,answers,mark,date) VALUES('$user_id','$id','$aanswers','$mark','$date')");
    if($add){
        $alert = '<div class="alert alert-success" role="alert">
        تم اضافة الحل بنجاح
     </div>';
    }else{
        $alert = '<div class="alert alert-danger" role="alert">
        لم يتم اضافة الحل! هناك خلل ما
     </div>';
    }
}
?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <div>
                                <h1 class="m-lg-0">اختبار</h1>
                            </div>
                            <?php if(strtotime($time) < strtotime(date('H:i:s')) && strtotime(date('H:i:s')) < strtotime($endtime)){ ?>
                            <div class="countdown" data-value="1.50"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                    <?= (isset($alert))? $alert : ' ' ?>
                    <?php 
                    $nnn = mysqli_query($conn,"SELECT * FROM quizes_answers WHERE student_id = '$user_id' AND quiz_id = '$id'");
                    $ifanswered = mysqli_num_rows($nnn);
                    if($ifanswered > 0){ 
                        $markk = mysqli_fetch_assoc($nnn);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="m-0 text-primary mr-2"><strong>تم تسليم الاختبار</strong></h4>
                            </div>
                            <div class="card-body">
                                <h4 class="">
                                    الدرجة الخاصة بك هي: <?= $markk['mark'] ?>/100
                                </h4>
                            </div>
                        </div>
                    <?php }else{
                        if(strtotime($time) < strtotime(date('H:i:s')) && strtotime(date('H:i:s')) < strtotime($endtime)){ ?>
                        <form method="post">
                        <div class="row">
                            <div class="col-md-8">
                                <?php 
                                $query = mysqli_query($conn,"SELECT * FROM questions WHERE quiz_id = $id");
                                $no = 1;
                                while($questions = mysqli_fetch_assoc($query)){ ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="media align-items-center">
                                            <div class="media-left">
                                                <h4 class="m-0 text-primary mr-2"><strong><?= $no ?></strong></h4>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="card-title m-0">
                                                    <?= $questions['question'] ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input id="customCheck1<?= $no ?>" type="radio" value="1" name="answer[<?= $no-1 ?>]" class="custom-control-input" required>
                                                <label for="customCheck1<?= $no ?>" class="custom-control-label"><?= $questions['answer1'] ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input id="customCheck2<?= $no ?>" type="radio" value="2" name="answer[<?= $no-1 ?>]" class="custom-control-input" required>
                                                <label for="customCheck2<?= $no ?>" class="custom-control-label"><?= $questions['answer2'] ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input id="customCheck3<?= $no ?>" type="radio" value="3" name="answer[<?= $no-1 ?>]" class="custom-control-input" required>
                                                <label for="customCheck3<?= $no ?>" class="custom-control-label"><?= $questions['answer3'] ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input id="customCheck4<?= $no ?>" type="radio" value="4" name="answer[<?= $no-1 ?>]" class="custom-control-input" required>
                                                <label for="customCheck4<?= $no ?>" class="custom-control-label"><?= $questions['answer4'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $no++; } ?>
                            </div>
                            <div class="col-md-4 ">
                                <div class="list-group">
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">نوع الاختبار</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $type ?>
                                            </span>
                                        </span>
                                    </a>
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">المدرس</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $teacher['fullname'] ?>
                                            </span>
                                        </span>
                                    </a>
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">المادة</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $subject['subject'] ?>
                                            </span>
                                        </span>
                                    </a>
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">التاريخ</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $date ?>
                                            </span>
                                        </span>
                                    </a>
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">الساعة</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $time ?>
                                            </span>
                                        </span>
                                    </a>
                                    <a class="list-group-item">
                                        <span class="media align-items-center">
                                            <span class="media-left mr-2">
                                                <span class="btn btn-light btn-sm">ينتهي في</span>
                                            </span>
                                            <span class="media-body">
                                                <?= $endtime ?>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <button name="submit" class="btn btn-success mt-3" type="submit">تسليم</button>
                            </div>
                        </div>
                        </form>
                        <?php }else{ ?>
                            <?php if(strtotime($time) > strtotime(date('H:i:s'))){ ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="m-0 text-primary mr-2"><strong>لم يحن موعد الاختبار</strong></h4>
                                    </div>
                                </div>
                            <?php }elseif(strtotime(date('H:i:s')) > strtotime($endtime)){ ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="m-0 text-primary mr-2"><strong>انتهى موعد الاختبار</strong></h4>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>
<?php include 'footer.php' ?>
