<?php include 'header.php' ?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الطلاب</h1>
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
                                                <th scope="col">الصورة</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">البريد الالكتروني</th>
                                                <th scope="col">الجوال</th>
                                                <th scope="col">العنوان</th>
                                                <th scope="col">الشعبة</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php  
                                              $ids = [];
                                              $teach = mysqli_query($conn,"SELECT * FROM teaching WHERE teacher_id = $user_id");
                                              while($teachs = mysqli_fetch_assoc($teach)){
                                                array_push($ids,$teachs['class']);
                                              }
                                              $ids = implode("','",$ids);
                                              $query = mysqli_query($conn,"SELECT * FROM students WHERE class IN ('".$ids."')");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                                $class_id = $results['class'];
                                                $class = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM classes WHERE id = '$class_id'"));
                                              ?>
                                              <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><img width="70" src="../images/students/<?= $results['image'] ?>" class="rounded-circle"></td>
                                                <td><?= $results['fullname'] ?></td>
                                                <td><?= $results['email'] ?></td>
                                                <td><?= $results['phone'] ?></td>
                                                <td><?= $results['address'] ?></td>
                                                <td><?= $class['grade'] ?>/<?= $class['class'] ?></td>
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