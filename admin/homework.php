<?php 
if(!isset($_GET['id'])){
    header('Location: homeworks.php');
}else{
    include 'header.php';
    $id = $_GET['id'];
    $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM homeworks WHERE id = $id"));
    $subject_id = $result['subject'];
    $subject = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subjects WHERE id = $subject_id"));
}

?>
                <div class="mdk-drawer-layout__content page">
                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                            <h1 class="m-lg-0">واجب منزلي</h1>
                        </div>
                    </div>
                    <div class="container-fluid page__container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3><?= $result['title'] ?></h3>
                                        <p><?= $subject['subject'] ?> - <?= $result['date'] ?></p>
                                        <hr>
                                        <p><?= $result['content'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include 'footer.php' ?>