<?php include 'header.php' ?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الاختبارات</h1>
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
                                                <th scope="col">المادة</th>
                                                <th scope="col">نوع الاختبار</th>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM quizes WHERE class = $user_class ORDER BY date");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                                if($results['type'] == 1){
                                                  $type = 'شهري';
                                                }elseif($results['type'] == 2){
                                                  $type = 'نصفي';
                                                }elseif($results['type'] == 3){
                                                  $type = 'نهائي';
                                                }
                                                $id = $results['id'];
                                                $qdate = $results['date'];
                                                $nowdate = date('Y-m-d');
                                                $subject_id = $results['subject'];
                                                $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = '$subject_id'"));
                                              ?>
                                              <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $subject['subject'] ?></td>
                                                <td><?= $type ?></td>
                                                <td><?= $results['date'] ?></td>
                                                <td><?= ($results['status'] == 0)? 'جديد' : 'منتهي' ?></td>
                                                <td>
                                                <?php 
                                                $nnn = mysqli_query($conn,"SELECT * FROM quizes_answers WHERE student_id = '$user_id' AND quiz_id = '$id'");
                                                $ifanswered = mysqli_num_rows($nnn);
                                                if($ifanswered == 0){
                                                  if($nowdate == $qdate){ ?>
                                                  <a class="btn btn-primary" href="take-quiz.php?id=<?= $results['id'] ?>">عرض</a>
                                                  <?php } ?>
                                                <?php }else{ ?>
                                                  <p>تم التسليم</p>
                                                <?php } ?>
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