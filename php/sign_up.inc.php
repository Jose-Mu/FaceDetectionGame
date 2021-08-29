<?php 

if (isset($_POST['signup-submit'])){

    require ('db_handler.php');

    $username = $_POST['username'];
    $email = $_POST['e_mail'];
    $typePassword = $_POST['user_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form

    // If forms are empty
    if (empty($username) || empty($email) || empty($typePassword) || empty($confirmPassword)) {
        header("Location: ../sign_up.php?error=emptyfields&username=".$username."&e_mail=".$email);
        exit();
    }

    // If email and username are invalid
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) ){
        header("Location: ../sign_up.php?error=invalidemailusername&");
        exit();
    } 

    // If email is invalid
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../sign_up.php?error=invalidemail&username=".$username);
        exit();
    }

    // If username is invalid
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../sign_up.php?error=invalidusername&e_mail=".$email);
        exit();
    }

    // If password and confirm password aren't match
    else if ($typePassword !== $confirmPassword ) {
        header("Location: ../sign_up.php?error=passwordcheck&username=".$username."&e_mail=".$email);
        exit();
    }

    else {
    // Prepare a select statement
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../sign_up.php?error=sqlerror");
            exit();
        }

        else {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"s", $username);

            // Attempt to execute the prepared statement
            mysqli_stmt_execute($stmt);
            
            // store result
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // If username is already taken
            if($resultCheck > 0) {
                header("Location: ../sign_up.php?error=usertaken&e_mail=".$email);
                exit();
            }
            
            else {
                $sql = "INSERT INTO users (username, e_mail, user_password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../sign_up.php?error=sqlerror");
                    exit();
                }
                else {
                    $hashPassword = password_hash($typePassword, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt,"sss", $username, $email, $hashPassword);
                    // Attempt to execute the prepared statement
                    mysqli_stmt_execute($stmt);
                    header("Location: ../sign_up.php?signup=success");
                    exit();
                    
                }

            }
        }

    }
    
    // Close statement
    mysqli_stmt_close($stmt);

     // Close connection
    mysqli_close($conn);
}
else {
    header("Location: ../sign_up.php");
    exit();
}


?>
