<?php 
include 'header.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($conn,"SELECT * FROM homeworks WHERE id = $id");
    $homework = mysqli_fetch_assoc($query);
}else{
    header('Location: homeworks.php');
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">حلول الواجبات المنزلية</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>محتوى الواجب:</h4>
                                        <p><?= $homework['content'] ?></p>
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">الطالب</th>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">الحل</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM homework_answers WHERE homework_id = $id");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                                $student_id = $results['student_id'];
                                                $student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = '$student_id'"));
                                              ?>
                                              <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $student['fullname'] ?></td>
                                                <td><?= $results['date'] ?></td>
                                                <td><a class="btn btn-success" href="../homeworks/<?= $results['filename'] ?>" download>الحل</a></td>
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