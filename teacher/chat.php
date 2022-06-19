<?php 
include '../inc/db.php';
include 'header.php';
if(isset($_POST['start'])){
    $user = $_POST['user'];
    $date = date('Y-m-d');
    $new_chat = mysqli_query($conn,"INSERT INTO chats(first_user_id,sec_user_id,date) VALUES('$user_id','$user','$date')");
    if($new_chat){
        $chat_id = mysqli_insert_id($conn);
    }else{
        $alert = '<div class="alert alert-soft-danger d-flex" role="alert">
                <div class="text-body">لم يتم بدء المحادثة بنجاح</div>
                </div>';
    }
}


?>
<style>
    .alrt {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: red;
        position: absolute;
    }
</style>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">المحادثات</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                    <?= (isset($alert))? $alert : '' ?>
                        <div class="row">
                            <div class="col-md-12 pb-3">
                                <h4>بدء محادثة جديدة</h4>
                                <form method="post">
                                    <div class="row">
                                        <div class="col">
                                            <select name="user" class="form-control">
                                                <option>اختر المستخدم</option>
                                                <?php 
                                                $query = mysqli_query($conn,"SELECT * FROM users WHERE usertype != 1");
                                                while($results = mysqli_fetch_assoc($query)){ 
                                                    $usrid = $results['id'];
                                                    if($results['usertype'] == 0){
                                                        $name = 'الادارة';
                                                    }else{
                                                        $get = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = $usrid"));
                                                        $name = $get['fullname'];
                                                    }
                                                    ?>
                                                    <option value="<?= $usrid ?>"><?= $name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="submit" name="start" class="btn btn-primary" value="بدء">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">اسم المستخدم</th>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">عرض</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query = mysqli_query($conn,"SELECT * FROM chats WHERE first_user_id = '$user_id' OR sec_user_id = '$user_id'");
                                                while($chats = mysqli_fetch_assoc($query)){
                                                    if($chats['first_user_id'] == $user_id){
                                                        $userid = $chats['sec_user_id'];
                                                    }else{
                                                        $userid = $chats['first_user_id'];
                                                    }
                                                    $get_user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id = $userid"));
                                                    $get_user_type = $get_user['usertype'];
                                                    if($get_user_type == 1){
                                                        $name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE user_id = $userid"));
                                                        $name = $name['fullname'];
                                                    }elseif($get_user_type == 2){
                                                        $name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE user_id = $userid"));
                                                        $name = $name['fullname'];
                                                    }else{
                                                        $name = 'المدير';
                                                    }
                                                    $num = 0;
                                                    $chat_id = $chats['id'];
                                                    $query1 = mysqli_query($conn,"SELECT * FROM chats_msg WHERE chat_id = $chat_id AND user_id != $user_id AND status = 0");
                                                    if(mysqli_num_rows($query1) > 0){
                                                        $num = 1;
                                                    }
                                                ?>
                                                <tr>
                                                <th scope="row">
                                                    <?= $no ?>
                                                    <?php if($num == 1){ ?>
                                                    <div class="alrt"></div>
                                                    <?php } ?>
                                                </th>
                                                <td><?= $name ?></td>                                                
                                                <td><?= $chats['date'] ?></td>                                                
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="open-chat.php?id=<?= $chats['id'] ?>">عرض</a>
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