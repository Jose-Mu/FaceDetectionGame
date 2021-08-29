<nav class="navbar navbar-light">
    <a class="navbar-brand">Face Expression Game</a>
    <div class="form-inline">
        <a href="./index.php"><button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Home</button></a>
        <a href="./leaderboard.php"><button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Leaderboard</button></a>
        

        <?php 
            // output log out button when logged in
            if (isset($_SESSION['username'])) {
                echo '
                <a href="./historyuser.php"><button class="btn btn-outline-warning my-2 my-sm-0" type="submit">History User</button></a>
                <form action="./php/logout.inc.php" method="post">
                    <button class="btn btn-outline-warning my-2 my-sm-0" type="submit" name="logout-submit">Log Out</button>
                </form>';
            }
            // output a log in and sign up button when logged out
            else {
                echo '
                <a href="./login.php"><button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Log In</button></a>

                <a href="./sign_up.php"><button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Sign Up</button></a>';
            }
        ?>

        
    </div>
</nav>