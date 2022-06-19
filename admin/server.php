<?php
if($_POST || $_GET)
{
include '../inc/db.php';

$user_id = $_POST['userid'];
$chat_id = $_POST['chatid'];
$date = date('Y-m-d');

if(isset($_POST['msg'])){
    $message = $_POST['msg'];
    $sql = "INSERT INTO chats_msg(chat_id,user_id,msg,date) VALUES('$chat_id','$user_id','$message','$date')";
    $send = mysqli_query($conn,$sql);
    if($send){
    }else{
        echo 'error!';
    }
}
 
$sql = "SELECT * FROM chats_msg WHERE chat_id = $chat_id ORDER BY id ASC";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    if($user_id == $row['user_id']){
    echo '<li class="r-msg">
    <div class="msg">'.$row['msg'].'</div>
    </li>';
    }else{ 
    echo '<li class="l-msg">
    <div class="msg">'.$row['msg'].'</div>
    </li>';
    }
}
}
?>