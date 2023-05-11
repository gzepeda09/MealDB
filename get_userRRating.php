<?php
	session_start();

	require_once("config.php");

	if(isset($_SESSION['userID'])){
		$uID = $_SESSION['userID'];
	}


	$db = get_pdo_connection();

    $query = $db->prepare("select UserMeals.*, Recipes.name from UserMeals join Recipes on UserMeals.recID = Recipes.recipeID where UserMeals.regUserID = ?");
	$query->bindParam(1, $uID, PDO::PARAM_INT);
	


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