<?php
	session_start();

	require_once("config.php");

	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
	}


	$db = get_pdo_connection();

    $query = $db->prepare("SELECT UserID, calorieGoal, email, fName, lName, isPrem, typeDiet FROM registeredUsers WHERE email = ?");
	$query->bindParam(1, $email, PDO::PARAM_STR);
	


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



?>