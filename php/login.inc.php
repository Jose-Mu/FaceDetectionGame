<?php 
 if (isset($_POST['login-submit'])) {
    require ('db_handler.php');

    $username = $_POST['username'];
    $typePassword = $_POST['user_password'];
    
    // If form is empty
    if (empty($username) || empty($typePassword)) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    else {
        $sql = "SELECT * FROM users WHERE username=?;";
        // Connect database
        $stmt = mysqli_stmt_init($conn);

        // If sql error
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../login.php?error=sqlerror");
            exit();
        }
        else {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $username);

            // Attempt to execute the prepared statement
            mysqli_stmt_execute($stmt);

            // store result
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_array($result)) {
                // Check password
                $passwordCheck = password_verify($typePassword, $row['user_password']);

                // If password false return to login page
                if ($passwordCheck == false) {
                    header("Location: ../login.php?error=wrongpassword");
                    exit();
                }

                // If password correct start session and return to homepage
                else if ($passwordCheck == true) {
                    session_start();
                    $_SESSION['user_id'] = $row['username'];
                    $_SESSION['username'] = $row['user_id'];

                    if($_SESSION["username"]) {
                        header("Location: ../index.php?login=success"); 
                       
                    }

                }
                else {
                    header("Location: ../login.php?error=sql error");
                    exit();
                }
            }
            else {
                header("Location: ../login.php?error=nouser");
                exit();
            }
        }
    }

 }
 else {
    header("Location: ../index.php");
    exit();
 }