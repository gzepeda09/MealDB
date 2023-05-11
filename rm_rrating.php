<?php
	session_start();

	require_once("config.php");

	if(!isset($_SESSION['userID'])){
		header('Location: frontend/log.php');
		exit();
	} else {
		$isPrem = $_SESSION['isPrem'];
	}

	if ($isPrem === 'N') {
	  // Redirect the user with an error message
	  session_write_close();
	  echo 'N';
	  exit();
	}  



	if(isset($_POST['umID'])){


		$umID = $_POST['umID'];
		$db = get_pdo_connection();

	    $query = $db->prepare("call deleteRating(?)");
		$query->bindParam(1, $umID, PDO::PARAM_INT);
		


		if (!$query->execute()) {
		    $errorInfo = $query->errorInfo();
		    // handle the error appropriately
		    // for example, print the error message to the console
		    error_log("Query error: " . $errorInfo[2]);
		}


		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		//return data as JSON for ajax call
		header('Content-Type: application/json');
		echo json_encode($results);

	}
	

?>