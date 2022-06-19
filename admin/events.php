<?php 
include 'header.php';

if(isset($_GET['del'])){
    $id = $_GET['del'];
      $delete = mysqli_query($conn,"DELETE FROM events WHERE id = $id");
      if($delete){
        $alert = '<div class="alert alert-soft-success d-flex" role="alert">
        <div class="text-body">تم حذف الحدث بنجاح</div>
        </div>';
      }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
        <div class="text-body">لم يتم حذف الحدث بنجاح</div>
        </div>';
      }
  }

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">الأحداث</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                    <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                               
                                                <th scope="col">العنوان</th>
                                                <th scope="col">المحتوى</th>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM events ORDER BY date");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                              ?>
                                              <tr>
                                                <td><?= $results['title'] ?></td>
                                                <td><?= $results['content'] ?></td>
                                                <td><?= $results['date'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-danger" href="events.php?del=<?= $results['id'] ?>">حذف</a>
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