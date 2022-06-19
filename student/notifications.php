<?php include 'header.php' ?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الاشعارات</h1>
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
                                                <th scope="col">المحتوى</th>
                                                <th scope="col">التاريخ</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM notifications WHERE usertype = 2 OR (usertype = 3 AND class = $user_class)");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                              ?>
                                              <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $results['content'] ?></td>
                                                <td><?= $results['date'] ?></td>
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