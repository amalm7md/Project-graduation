<?php 
if(!isset($_GET['id'])){
    header('Location: quizes.php');
}else{
    include 'header.php';
    $id = $_GET['id'];
    $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM quizes WHERE id = $id"));
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
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">عرض اختبار</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>امتحان <?= $type ?></h3>
                                        <p><?= $subject['subject'] ?> - <?= $result['date'] ?></p>
                                        <hr>
                                        <?php  
                                        $qq = mysqli_query($conn,"SELECT * FROM questions WHERE quiz_id = $id");                                        
                                        while($questions = mysqli_fetch_assoc($qq)){
                                        ?>
                                        <?= $questions['question'] ?>
                                        <ul>
                                        <li><?= $questions['answer1'] ?></li>
                                        <li><?= $questions['answer2'] ?></li>
                                        <li><?= $questions['answer3'] ?></li>
                                        <li><?= $questions['answer4'] ?></li>
                                        <li>الاجابة الصحيحة: <?= $questions['correct'] ?></li>
                                        </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>الطلاب المتقدمون</h3>
                                        <hr>
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">الدرجة</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                        <?php  
                                        $no = 1;
                                        $qq = mysqli_query($conn,"SELECT * FROM quizes_answers WHERE quiz_id = $id");                                        
                                        while($questions = mysqli_fetch_assoc($qq)){
                                            $std_id = $questions['student_id'];
                                            $get_std = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = '$std_id'"));
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $get_std['fullname'] ?></td>
                                                <td><?= $questions['mark'] ?></td>
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