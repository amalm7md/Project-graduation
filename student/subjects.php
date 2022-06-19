<?php include 'header.php'; ?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المواد</h1>
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
                                                <th scope="col">الاسم</th>
                                                <th scope="col">المدرس</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $no = 1;
                                                $query = mysqli_query($conn,"SELECT * FROM subjects");
                                                while($results = mysqli_fetch_assoc($query)){
                                                    $id = $results['id'];
                                                    $teaching = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teaching WHERE subject='$id' AND class='$user_class'"));
                                                    $teacher_id = $teaching['teacher_id'];
                                                    $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id='$teacher_id'"));
                                                ?>
                                              <tr>
                                                <th scope="row"><?= $no; ?></th>
                                                <td><?= $results['subject'] ?></td>
                                                <td><?= $teacher['fullname'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="homeworks.php">عرض الواجبات</a>
                                                    </div>
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