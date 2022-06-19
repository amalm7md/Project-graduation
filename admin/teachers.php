<?php 
include 'header.php';

if(isset($_GET['del'])){
  $id = $_GET['del'];
  $delete = mysqli_query($conn,"DELETE FROM teachers WHERE user_id = $id");
  if($delete){
    $delete = mysqli_query($conn,"DELETE FROM users WHERE id = $id");
    if($delete){
      $alert = '<div class="alert alert-soft-success d-flex" role="alert">
      <div class="text-body">تم حذف المدرس بنجاح</div>
      </div>';
    }else{
      $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
      <div class="text-body">لم يتم حذف المدرس بنجاح</div>
      </div>';
    }
  }else{
    $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
    <div class="text-body">لم يتم حذف المدرس بنجاح</div>
    </div>';
  }
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المدرسين</h1>
                            <a class="btn btn-primary" href="add-teacher.php">اضافة مدرس</a>
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
                                                <th scope="col">#</th>
                                                <th scope="col">الصورة</th>
                                                <th scope="col">اسم المستخدم</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">البريد الالكتروني</th>
                                                <th scope="col">الجوال</th>
                                                <th scope="col">العنوان</th>
                                                <th scope="col">خيارات</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php  
                                              $query = mysqli_query($conn,"SELECT * FROM users WHERE usertype = 1");
                                              $no = 1;
                                              while($results = mysqli_fetch_assoc($query)){
                                                $id = $results['id'];
                                                $teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $id"));
                                              ?>
                                              <tr>
                                                <th scope="row"><?= $no ?></th>
                                                <td><img width="70" src="../images/teachers/<?= $teacher['image'] ?>" class="rounded-circle"></td>
                                                <td><?= $results['username'] ?></td>
                                                <td><?= $teacher['fullname'] ?></td>
                                                <td><?= $teacher['email'] ?></td>
                                                <td><?= $teacher['phone'] ?></td>
                                                <td><?= $teacher['address'] ?></td>
                                                <td>
                                                <div class="btn-group">
                                                  <a class="btn btn-primary" href="add-teacher.php?id=<?= $id ?>">تعديل</a>
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