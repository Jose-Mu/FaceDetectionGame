<?php
session_start();
include_once('php/db_handler.php');

if( isset( $_SESSION['username'])){
    $thisUser = $_SESSION['username'];
}   
$sql_history = "SELECT `photo_id`, date_format(CONVERT_TZ(`created_at`,'+00:00','+07:00'), '%d %M %Y - %h:%i %p') AS `created_time`, `score`, `emotion` ,`image_path` FROM `snapshots` WHERE `user_no` = '".$thisUser."' ";
$result = mysqli_query($conn,$sql_history);
$resultCheck = mysqli_num_rows($result);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/historyuser.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="lightbox/css/lightbox.min.css">
    <title>History User | Face Expression Game</title>
    <?php include_once("./head.php") ?>
</head>

<body translate="no">

    <!-- Navbar -->
    <?php include_once("./navbar.php")?>

    <section class="timeline">
        <ul>
            <?php 
                if($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
            ?>
            
            <li class='in-view'>
                <div>
                    <time><?php echo $row['created_time']; ?></time>
                    <div class='discovery'>
                        <a href='img/snapshots/<?php echo $row['image_path']; ?>' data-lightbox="snapshots-<?php echo $row['photo_id']; ?>" data-title="
                        
                            <div class='process text-left mt-3'>
                                <a href='img/snapshots/<?php echo $row['image_path']; ?>' download>
                                    <button class='btn btn-primary mr-3 p-2 download'><img class='mr-2'src='./img/icon/download.svg' width='20px' style='filter: invert(1)'>Download</button>
                                </a>
                                <a href='javascript:confirmation(<?php echo $row['photo_id']; ?>)'>
                                    <button class='btn btn-danger p-2 delete'>
                                        <img class='mr-2'src='./img/icon/delete.svg' width='20px' style='filter: invert(1)'>Delete Record
                                    </button>
                                </a>
                            </div>
                        
                        
                        ">
                            <img width='70px' class='myImage' src='img/snapshots/<?php echo $row['image_path']; ?>'>
                        </a>
                        <p>You are <?php echo $row['emotion']; ?></p>
                    </div>
                    <div class='scientist'>
                        <h1><?php echo $row['score'];?></h1>
                        <span>Point</span>
                    </div>
                </div>
            </li>

            <?php
                    }
                }
                else {
                    echo "<div class='box'><h1>No History!</h1> <p>You haven't saved any game record...</p></div>";
                }
            ?>
        </ul>

        <?php 
        
        ?>
        
    </section>
    <script src="./js/historyuser.js"></script>
    <script src="./lightbox/js/lightbox-plus-jquery.min.js"></script>
</body>

</html>