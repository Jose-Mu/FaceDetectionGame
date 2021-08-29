<?php
    session_start();
	require('db_handler.php'); // Connect to database
 

    $userId = $_SESSION['username'];
	// Fetch photo only if product id is not empty
	if (!empty($userId)) {

		$resultScore = $_POST['myScore'];
		$resultEmotion = $_POST['myEmotion'];
		$rawData = $_POST['imgBase64'];
 
		list($type, $rawData) = explode(';', $rawData);
		list(, $rawData)      = explode(',', $rawData);
		$unencoded = base64_decode($rawData);
		
		date_default_timezone_set('Asia/Jakarta');
		
		$filename = $userId.'_'.date('dmYHi').'_'.rand(1111,9999).'.png'; // Set a filename
		file_put_contents("../img/snapshots/$filename", base64_decode($rawData)); // Save photo to folder
 
		// Update product database with the new filename
		$sql = "INSERT INTO `snapshots`(`user_no`,`image_path`,`score`,`emotion`) VALUES ('$userId','$filename','$resultScore','$resultEmotion')";
        
        if ($conn->query($sql) === FALSE) {
			echo "Failed to save.";
		}
 
	} 
	
	// 
	else {
		die('Unable to upload...');
	}
 
?>