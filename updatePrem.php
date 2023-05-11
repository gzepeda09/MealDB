<?php

	session_start();


	if(isset($_POST['submit'])){
		require_once("config.php");
		if(isset($_SESSION['userID'])){
			$uID = $_SESSION['userID'];
			$premStat = $_SESSION['isPrem'];
		}
		else{
			header('Location: frontend/log.php');
			exit();
		}

		if($premStat === 'Y'){
		    $premStat = 'N';
		    $_SESSION['isPrem'] = $premStat;
		} else if($premStat === 'N'){
		    $premStat = 'Y';
		    $_SESSION['isPrem'] = $premStat;
		} 

		$db = get_pdo_connection();

	    $query = $db->prepare("call updateUserPrem(?, ?)");
		$query->bindParam(1, $uID, PDO::PARAM_INT);
		$query->bindParam(2, $premStat, PDO::PARAM_STR);
		


		if (!$query->execute()) {
		    $errorInfo = $query->errorInfo();

		    error_log("Query error: " . $errorInfo[2]);
		}


		if ($query->rowCount() > 0) {
			// Update was successful
			header('Location: frontend/userProf.php');
			exit();
		} else {
			// Update failed
			header('Location: frontend/userProf.php?error=upFailed');
			exit();
		}

	}
		
?>