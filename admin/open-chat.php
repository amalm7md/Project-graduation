<?php 
include 'header.php';

if(isset($_GET['id'])){
    $chat_idd = $_GET['id'];
    mysqli_query($conn,"UPDATE chats_msg SET status = 1 WHERE chat_id = $chat_idd");

?>
<style>
    .chat {
        border: 1px solid lightgrey;
        border-radius: 15px;
        margin: 20px;
        height: 300px;
        overflow: auto;
    }
    .chat .chat-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .chat .r-msg .msg {
        border-radius: 15px;
        text-align: right;
        float: right;
        width: 80%;
        background: #e1e1e1;
        padding: 8px;
        margin: 2px;
    }
    .chat .l-msg .msg {
        border-radius: 15px;
        text-align: left;
        float: left;
        width: 80%;
        background: rgb(18, 119, 201, 0.4);
        padding: 8px;
        margin: 2px;
    }
</style>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">محادثة</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body chat" id="chat">
                                        <ul class="chat-list" id="results">
                                            
                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-10">
                                                <input type="text" id="msg" class="form-control">
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" id="send" class="btn btn-primary">ارسل</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // END drawer-layout__content -->
<?php include 'footer.php' ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        function foo () { 
        $.ajax({
              url: 'server.php',
              type:'POST',
              data: {
                userid: <?= $user_id ?>,
                chatid: <?= $chat_idd ?>,
              },
              success: function(data) {
                $('#results').html(data);
                $('#chat').scrollTop($('#chat')[0].scrollHeight);
              }
            });
        }
        setInterval(foo, 1000);
        $('#send').on('click', function(){
            var msg = $('#msg').val();
            if( msg.length === 0 ) {
                alert('حقل الرسالة فارغ!');
            }else{
                $.ajax({
                url: 'server.php',
                type:'POST',
                data: {
                    msg: msg,
                    userid: <?= $user_id ?>,
                    chatid: <?= $chat_idd ?>,
                },
                success: function(data) {
                    $('#msg').val('');
                    $('#results').html(data);
                    $('#chat').scrollTop($('#chat')[0].scrollHeight);
                }
                });
            }
        });
    });
    
</script>
<?php
}else{
    header('Location: chat.php');
}
?>