<?php 
session_start(); 
include_once('php/db_handler.php');

$sql_rank = "SELECT `username`, (MAX(`score`)) AS `high_score`, (dense_rank() OVER(ORDER BY `high_score` DESC)) AS `my_rank`
FROM `snapshots` LEFT JOIN `users` ON `user_no` = `user_id` GROUP BY `user_no` ORDER BY `my_rank` ";
$result = mysqli_query($conn,$sql_rank);
$resultCheck = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/leaderboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://rsms.me/inter/inter-ui.css?v=3.2">
    <title>Leaderboard | Face Expression Game</title>
    <?php include_once("./head.php") ?>
           
</head>

<body translate="no">

    <!-- Navbar -->
    <?php include_once("./navbar.php")?>

    <div class="wrapper">
        <div class="list">
            <div class="list__header">
                <h5>Result</h5>
                <h1>Face Expression Game</h1>
                <?php 
                    if( isset( $_SESSION['user_id'])){
                        $thisUser = $_SESSION['user_id'];
                        $sql_myrank = "SELECT user.`my_rank` FROM ($sql_rank) AS user WHERE `username` = '".$thisUser."' ";
                        $result_myrank = mysqli_query($conn, $sql_myrank);
                        $resultmyrankCheck = mysqli_num_rows($result_myrank);
                        
                        if($resultmyrankCheck > 0 && !empty($result_myrank)){
                            $row = mysqli_fetch_array($result_myrank);
                            echo "<p>My Rank : ".$row['my_rank']." </p>";
                        }
                        else{
                            echo "<span>You don't have a rank... Play the game now!</span>";
                        }
                        
                    } 
                ?>
            </div>
            <div class="list__body">
                <table class="list__table">
                    <tbody>
                        <?php 
                        if($resultCheck > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "
                                <tr class='list__row'>
                                    <td class='list__cell'><span class='list__value'>".$row['my_rank']."</span></td>
                                    <td class='list__cell'><span class='list__value'>".$row['username']."</span></td>
                                    <td class='list__cell'><span class='list__value'></span></td>
                                    <td class='list__cell'><span class='list__value'>".$row['high_score']."</span><small class='list__label'>Points</small></td>
                                </tr>";
                            };
                        };
                        
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>