<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <title>Play the Game | Face Expression Game</title>
    <?php include_once("./head.php") ?>
</head>

<body>
    <!-- If not logged in, return to login page -->
    <?php
    if (!isset($_SESSION['username'])) {
        header("Location: ./login.php");
    }
    ?>
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12">
                <!-- Title -->
                <h1 class="title center">Face Expression Game</h1>
            </div>
            <div class="col-lg-7 col-xs-12">
                <!-- Webcam screen-->
                <div class="web_cam center">
                    <video id="video" autoplay muted>
                    </video>
                </div>
                <canvas id="snapshot_result"></canvas>
                <div id="progressBar">
                    <div class="bar"></div>
                </div>
                <!-- Capture button to start the game -->
                <div class="controller">
                    <button id="startbutton" class="game_start_btn">Start Game</button>
                    <button onclick="playAgain()" id="playagain" class="again">Play Again</button>
                    <button id="savebutton" class="save">Save</button>
                    <a href="./index.php"><button id="homebutton" class="home-btn">Back to Home</button></a>
                </div>
            </div>
        
            <div class="col-lg-5 co1-xs-12">
                
                <!-- Snapshot result -->
                <div class="box">
                    <div class="text">
                        <h1 id="question"></h1>
                        <p id="myEmotion"></p>
                        <p id="myScore"></p>
                        <p id="undetect"></p>
                        <p class="manual"><em>Make sure the blue box is appearing. The blue box will detect your expression. <br><br>
                            How to play : <br> Click <b>'Start Game'</b> to play. Question will be shown below this text. You only have 5 seconds to make the expression based on the question. After that, you may see your photo's result with your score and expression. If you'd like to save the result to your history, click <b>'Save'</b>. Good Luck and Have Fun !</em> 
                        </p>
                        <p id="seeresult"></p>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <script defer src="js/face-api.min.js"></script>

    <script defer src="js/main.js"></script>
</body>

</html>