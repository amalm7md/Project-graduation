<?php include 'header.php' ?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الواجبات المنزلية</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">المدرس</th>
                                                <th scope="col">المادة</th>
                                                <th scope="col">الشعبة</th>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM homeworks");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                                $teacher_id = $results['teacher_id'];
                                                $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $teacher_id"));
                                                $class_id = $results['class'];
                                                $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = '$class_id'"));
                                                $subject_id = $results['subject'];
                                                $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = '$subject_id'"));
                                              ?>
                                              <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $teacher['fullname'] ?></td>
                                                <td><?= $subject['subject'] ?></td>
                                                <td><?= $class['grade'] ?>/<?= $class['class'] ?></td>
                                                <td><?= $results['date'] ?></td>
                                                <td><?= ($results['status'] == 0)? 'جديد':'منتهي' ?></td>
                                                <td><a class="btn btn-primary" href="homework.php?id=<?= $results['id'] ?>">عرض</a></td>
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