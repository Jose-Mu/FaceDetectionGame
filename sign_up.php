<?php session_start ()?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <title>Sign Up | Face Expression Game</title>
    <?php include_once("./head.php") ?>
</head>

<body>

    <!-- Navbar -->
    <?php include_once("./navbar.php")?>
    
    <section class="wrapper sign-up">


        <!-- Add error message -->
        
        <!-- Sign up form -->
        <form action="./php/sign_up.inc.php" method="post" class="form signup-form">
            <h1>Sign Up</h1>

            <!-- Error alert -->
            <?php 
                if (isset($_GET['error'])) {
                    // If submit empty field
                    if($_GET['error'] == "emptyfields"){
                        echo '<p class="signup_error">Please fill all the fields!</p>';
                    }
                    // If submit empty email and username
                    else if($_GET['error'] == "invalidemailusername"){
                        echo '<p class="signup_error">Invalid email and username!</p>';
                    }
                    // If submit invalid email
                    else if($_GET['error'] == "invalidemail"){
                        echo '<p class="signup_error">Invalid email!</p>';
                    }
                    // If submit invalid username
                    else if($_GET['error'] == "invalidusername"){
                        echo '<p class="signup_error">Invalid username! <br> A username can only contain alphanumeric characters (letters A-Z, numbers 0-9)</p>';
                    }
                    // Passwords do not match
                    else if($_GET['error'] == "passwordcheck"){
                        echo '<p class="signup_error">Your passwords do not match!</p>';
                    }
                    // If email is taken
                    else if($_GET['error'] == "usertaken"){
                        echo '<p class="signup_error">This username is taken!</p>';
                    }
                }
                else if (isset($_GET['signup'])) {
                    if($_GET['signup'] == "success"){
                        echo '<p class="signup_success">Your account has already been added. Please <a class="user-link" href="./login.php"><b>log in here</b></a></p>';
                    }
                }
                else {
                echo '<p style="opacity: 0.5; text-align: center;">Please fill in this form to create an account!</p>';
                }
            ?>

            <!-- Input username -->
            <div class="txtb">
                <input type="text" name="username">
                <span data-placeholder="Username"></span>
            </div>

            <!-- Input email -->
            <div class="txtb">
                <input type="text" name="e_mail">
                <span data-placeholder="E-mail"></span>
            </div>
            
            <!-- Input password -->
            <div class="txtb">
                <input type="password" name="user_password">
                <span data-placeholder="Password"></span>
            </div>

            <!-- Re-type inputted password -->
            <div class="txtb">
                <input type="password" name="confirm_password">
                <span data-placeholder="Confirm Your Password"></span>
            </div>

            <!-- Submit button -->
            <button type="submit" name="signup-submit" class="submit-btn">Sign Up</button>

            <div class="bottom-text">
                Already have an account? <a class="user-link" href="./login.php"><b>Log In</b></a>
            </div>

        </form>

    </section>

    <script type="text/javascript">
        $(".txtb input").on("focus", function () {
            $(this).addClass("focus");
        });

        $(".txtb input").on("blur", function () {
            if ($(this).val() == "")
                $(this).removeClass("focus");
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>