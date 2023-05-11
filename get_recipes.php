<?php
	session_start();

	require_once("config.php");


	$db = get_pdo_connection();

    // query for getting recipes
    $query = $db->prepare("SELECT * FROM Recipes");
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_ASSOC);
 

	




	//return data as JSON for ajax call
	header('Content-Type: application/json');
	echo json_encode($results);



?>