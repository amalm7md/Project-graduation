<?php 
include 'header.php';
?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المكتبة</h1>
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
                                                <th scope="col">اسم الرابط</th>
                                                <th scope="col">الرابط</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($conn,"SELECT * FROM urls WHERE teaching_id = '$user_class'");
                                                while($teaching = mysqli_fetch_assoc($query)){
                                                ?>
                                                <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $teaching['url_name'] ?></td>                                                
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="<?= $teaching['url'] ?>" target="_blank">عرض</a>
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
                <!-- // END drawer-layout__content -->
<?php include 'footer.php' ?>