<?php
    session_start();
    include_once "db_handler.php"; 
    
    $id = $_GET['photo_id'];
    $sql_delete = "DELETE FROM `snapshots` WHERE `photo_id` = '".$id."'";
    
    $del = mysqli_query($conn, $sql_delete);
    
    if($del)
    {
        header("location:../historyuser.php");
        exit;	
    }
    else
    {
        echo "Error deleting record"; // display error message if not delete
    }

?>