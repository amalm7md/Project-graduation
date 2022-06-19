<?php 
include 'header.php';

$ids = [];
$cls = [];
$teach = mysqli_query($conn,"SELECT * FROM teaching WHERE teacher_id = $user_id");
while($teachs = mysqli_fetch_assoc($teach)){
    array_push($ids,$teachs['subject']);
    array_push($cls,$teachs['class']);
}

if(isset($_POST['add'])){
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $questions = $_POST['questions'];
    $answers1 = $_POST['answer1'];
    $answers2 = $_POST['answer2'];
    $answers3 = $_POST['answer3'];
    $answers4 = $_POST['answer4'];
    $correct_answers = $_POST['correct_answer'];
    $add_quiz = mysqli_query($conn,"INSERT INTO quizes(teacher_id,subject,class,type,date,time) VALUES('$user_id','$subject','$class','$type','$date','$time')");
    if($add_quiz){
        $quiz_id = mysqli_insert_id($conn);
        foreach ($questions as $index => $question) {
            $answer1 = $answers1[$index];
            $answer2 = $answers2[$index];
            $answer3 = $answers3[$index];
            $answer4 = $answers4[$index];
            $correct_answer = $correct_answers[$index];
            $add_quistion = mysqli_query($conn,"INSERT INTO questions(quiz_id,question,answer1,answer2,answer3,answer4,correct) VALUES('$quiz_id','$question','$answer1','$answer2','$answer3','$answer4','$correct_answer')");
            if($add_quistion){
                $event = mysqli_query($conn,"INSERT INTO events(title,content,date,ev_type) VALUES('اختبار جديد','تم اضافة اختبار','$date','1')");
                if($event){
                        $now = date('Y/m/d');
                        $time = date('H:m');
                        $logs = mysqli_query($conn,"INSERT INTO logs(user_id,content,date,time) VALUES('$user_id','تم اضافة اختبار','$now','$time')");
                        if($logs){
                        $alert = '<div class="alert alert-success" role="alert">
                        تم اضافة الاختبار بنجاح
                    </div>';
                    }else{
                        $alert = '<div class="alert alert-danger" role="alert">
                        لم يتم اضافة الاختبار! هناك خلل ما
                    </div>';
                    }
                }else{
                    $alert = '<div class="alert alert-danger" role="alert">
                        لم يتم اضافة الاختبار! هناك خلل ما
                    </div>';
                }
            }else{
                $alert = '<div class="alert alert-danger" role="alert">
                    لم يتم اضافة الاختبار! هناك خلل ما
                </div>';
            }
        }
    }else{
        $alert = '<div class="alert alert-danger" role="alert">
         هناك خلل ما حاول مرة أخرى لاحقاً!
      </div>';
    }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">انشاء اختبار</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <?= (isset($alert))? $alert : ' ' ?>
                    <form method="post">
                        <div class="card">
                            <div class="card-body card-form__body">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="control-label h6">نوع الاختبار:</label>
                                        <select name="type" class="form-control">
                                            <option value="1">شهري</option>
                                            <option value="2">نصفي</option>
                                            <option value="3">نهائي</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 mb-3">
                                        <label class="control-label h6">التاريخ:</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3 mb-3">
                                        <label class="control-label h6">الساعة:</label>
                                        <input type="time" name="time" class="form-control">
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
                                </div>
                            </div>
                        </div>
                        <div id="questions_wrapper">
                            <div id="quistions" action="#">
                                <div class="card mb-4">
                                    <div class="card-header d-flex">
                                        <span class="p-2">1</span>
                                        <div class="w-75">
                                            <input type="text" name="questions[]" class="form-control" placeholder="سؤال جديد">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="answerWrapper_1" class="mb-4">
                                            <ul class="list-group" id="answer_container_1">
                                                <li class="list-group-item d-flex">
                                                    <div class="w-75">
                                                        <input class="form-control" name="answer1[]" type="text" placeholder="الاجابة الاولى">
                                                    </div>
                                                    <div class="ml-auto">
                                                        <input type="radio" name="correct_answer[0]" value="1" id="correct_answer_1">
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <div class="w-75">
                                                        <input class="form-control" name="answer2[]" type="text" placeholder="الاجابة الثانية">
                                                    </div>
                                                    <div class="ml-auto">
                                                        <input type="radio" name="correct_answer[0]" value="2" id="correct_answer_1">
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <div class="w-75">
                                                        <input class="form-control" name="answer3[]" type="text" placeholder="الاجابة الثالثة">
                                                    </div>
                                                    <div class="ml-auto">
                                                        <input type="radio" name="correct_answer[0]" value="3" id="correct_answer_1">
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <div class="w-75">
                                                        <input class="form-control" name="answer4[]" type="text" placeholder="الاجابة الثالثة">
                                                    </div>
                                                    <div class="ml-auto">
                                                        <input type="radio" name="correct_answer[0]" value="4" id="correct_answer_1">
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="form-group mb-0">
                                    <a id="add_answer" class="btn btn-outline-primary">سؤال جديد</a>
                                    <button type="submit" name="add" class="btn btn-primary">انشاء</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
<?php include 'footer.php' ?>
<script>
    $(document).ready(function(){
        var nn = 2;
        $("#add_answer").click(function(){
            $("#quistions").append('<div class="card mb-4"><div class="card-header d-flex"><span class="p-2">'+nn+'</span><div class="w-75"><input type="text" name="questions[]" class="form-control" placeholder="سؤال جديد"></div></div><div class="card-body"><div id="answerWrapper_1" class="mb-4"><ul class="list-group" id="answer_container_1"><li class="list-group-item d-flex"><div class="w-75"><input class="form-control" name="answer1[]" type="text" placeholder="الاجابة الاولى"></div><div class="ml-auto"><input type="radio" value="1" name="correct_answer['+(nn-1)+']" id="correct_answer_1"></div></li><li class="list-group-item d-flex"><div class="w-75"><input class="form-control" name="answer2[]" type="text" placeholder="الاجابة الثانية"></div><div class="ml-auto"><input type="radio" value="2" name="correct_answer['+(nn-1)+']" id="correct_answer_1"></div></li><li class="list-group-item d-flex"><div class="w-75"><input class="form-control" name="answer3[]" type="text" placeholder="الاجابة الثالثة"></div><div class="ml-auto"><input type="radio" value="3" name="correct_answer['+(nn-1)+']" id="correct_answer_1"></div></li><li class="list-group-item d-flex"><div class="w-75"><input class="form-control" name="answer4[]" type="text" placeholder="الاجابة الثالثة"></div><div class="ml-auto"><input type="radio" value="4" name="correct_answer['+(nn-1)+']" id="correct_answer_1"></div></li></ul></div></div></div>');
            nn = nn+1;
        });
    });
</script>