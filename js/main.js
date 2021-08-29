const video = document.getElementById('video');

// Hide unnecessary
$('#playagain').hide();
$('#savebutton').hide();
$('#snapshot_result').hide();
$('#myScore').hide();
$('#myEmotion').hide();

// Include face detection api
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('/models')
]).then(startVideo);

// Start video function
function startVideo() {
    navigator.getUserMedia({
            video: {}
        },
        stream => {
            video.srcObject = stream
        },
        err => console.error(err)
    )
}

// When video play add face detection canvas
video.addEventListener("play", () => {
    const canvas = faceapi.createCanvasFromMedia(video); // Declare canvas
    let web_cam = document.querySelector(".web_cam"); //Select web_cam class
    const displaySize = {
        width: video.offsetWidth,
        height: video.offsetHeight
    }; // Declare display size

    // insert canvas to web_cam class
    web_cam.append(canvas);

    faceapi.matchDimensions(canvas, displaySize); //match canvas and video size

    // Declare global variables for calculate score and output result's emotion
    var playerEmotion;
    var playerScore;

    var intervals = setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();


        const resizedDetections = faceapi.resizeResults(detections, displaySize);

        const getNestedObject = (nestedObj, pathArr) => {
            return pathArr.reduce((obj, key) =>
                (obj && obj[key] !== 'undefined') ? obj[key] : undefined, nestedObj);
        };

        const expressions = getNestedObject(resizedDetections, [0, 'expressions']); // Get expressions data from nested array

        // Draw detection
        canvas.getContext('2d').clearRect(0, 0, canvas.offsetWidth, canvas.offsetHeight);
        faceapi.draw.drawDetections(canvas, resizedDetections);
        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

        // Get score and emotion data
        if (resizedDetections[0] && Object.keys(resizedDetections[0]).length > 0 && expressions !== null && expressions !== undefined) {
            // Declare variables for counting score
            const maxValue = Math.max(...Object.values(expressions));
            const emotion = Object.keys(expressions).filter(
                item => expressions[item] === maxValue
            );

            // Calculate score if correct
            if (question === emotion[0]) {
                score = (maxValue * 1000).toFixed(2);
                playerEmotion = emotion[0];
                playerScore = score;
                fetchResult();
            }
            // Calculate score if wrong
            else if (question !== emotion[0]) {
                score = (maxValue * 400).toFixed(2);
                playerEmotion = emotion[0];
                playerScore = score;
                fetchResult();

            }

            $("#undetect").hide();

        }
        // If face is not detected score will be 0
        else if (expressions === null || expressions === undefined) {
            document.getElementById("undetect").innerText = `Can't detect your face. Please reposition your face...`;
            score = 0;
            playerEmotion = 'none';
            playerScore = score;
            fetchResult();
            $("#undetect").show();
        }

    }, 100);

    var listEmotion = ['angry', 'disgusted', 'fearful', 'happy', 'neutral', 'sad', 'surprised']; // Declare question array
    var question = listEmotion[Math.floor(Math.random() * listEmotion.length)]; // Generate question randomly


    // Fetch score and emotion result from face detection setInterval
    function fetchResult() {
        var fetchEmotion = playerEmotion;
        var fetchplayerScore = playerScore;
        document.getElementById("myScore").innerText = `Your score is ${fetchplayerScore}`;
        document.getElementById("myEmotion").innerText = `You are now feeling ${fetchEmotion}`;
    }

    var result = document.getElementById('snapshot_result'),
        context = result.getContext('2d'),
        dataUrl = '';
    result.width = video.offsetWidth;
    result.height = video.offsetHeight;
    // Capture
    $("#startbutton").one('click', function () {
        // Show question
        $('#startbutton').hide();
        document.getElementById("question").innerText = `Make ${question} expression`;

        // Will capture photo after 6s
        setTimeout(function () {
            //Pause Video
            video.pause();
            $("#undetect").hide();

            // Draw snapshot canvas
            context.drawImage(video, 0, 0, video.offsetWidth, video.offsetHeight);
            dataUrl = result.toDataURL("image/png");

            // Show
            $('#myScore').show();
            $('#myEmotion').show();
            $('#snapshot_result').show();
            $('#playagain').show();
            $('#savebutton').show();

            // Hide
            $('#video').hide();

            // Get Result
            fetchResult();


            // stop intervals
            clearInterval(intervals);

        }, 6000);

        // Progress bar for 5s
        function progress(timeleft, timetotal, $element) {
            var progressBarWidth = timeleft * $element.width() / timetotal;
            $element.find('div').animate({
                width: progressBarWidth
            }, 500).html(Math.floor(timeleft / 60) + ":" + timeleft % 60);
            if (timeleft > 0) {
                setTimeout(function () {
                    progress(timeleft - 1, timetotal, $element);
                }, 1000);
            }
        }

        progress(5, 5, $('#progressBar'));

    });

    // Save game record
    $(document).one('click', '#savebutton', function () {
        var fetchEmotion = playerEmotion;
        var fetchplayerScore = playerScore;

        $.ajax({
            type: "POST",
            url: "/../php/savepicture.php?id=<?php echo $_SESSION[$username}?>",
            data: {
                imgBase64: dataUrl,
                myScore: fetchplayerScore,
                myEmotion: fetchEmotion
            },
            success: function (data) {
                $("#seeresult").html(data);
                alert("Your game record has been saved to history");
            },
            error: function () {
                alert("failure");
                $("#seeresult").html('There is error while submit');
            }
        });

    });

});

//Refresh Game
function playAgain() {
    window.location.reload();
}