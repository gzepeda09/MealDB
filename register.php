<?php 
	session_start();

	if(isset($_POST["submit"])){
		require_once("config.php");


		$fName = htmlspecialchars($_POST["fName"]);
	    $lName = htmlspecialchars($_POST["lName"]);
	    $cGoal = htmlspecialchars($_POST["cGoal"]);
	    $tDiet = htmlspecialchars($_POST["tDiet"]);
	    $email = htmlspecialchars($_POST["email"]);
	    $pwd = htmlspecialchars($_POST["pwd"]);
	    $repwd = htmlspecialchars($_POST["repwd"]);
	    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);


		if (empty($fName) || empty($lName) || empty($cGoal) || empty($tDiet) || empty($email) || empty($pwd) || empty($repwd)) { 
			    header("Location:frontend/reg.php?error=emptyinput");
    			exit();
		} 


	    if($pwd !== $repwd){

	    	header("Location: frontend/reg.php?error=mismatchPasswords");
			exit();
	    }

	   	$db = get_pdo_connection();

	    // check if user exists already
	    $query = $db->prepare("SELECT COUNT(*) FROM registeredUsers WHERE email = ?");
		$query->bindParam(1, $email, PDO::PARAM_STR);
		$query->execute();
		$count = $query->fetchColumn();

		if($count > 0){
			header("Location: frontend/reg.php?error=userExists");
			exit();
		}





	    $query = $db->prepare("insert into registeredUsers (fName, lName, calorieGoal, typeDiet, password, email) values (?, ?, ?, ?, ?, ?)");
	    $query->bindParam(1, $fName, PDO::PARAM_STR);
	    $query->bindParam(2, $lName, PDO::PARAM_STR);
	    $query->bindParam(3, $cGoal, PDO::PARAM_INT);
	    $query->bindParam(4, $tDiet, PDO::PARAM_STR);
	    $query->bindParam(5, $hashedPwd, PDO::PARAM_STR);
	    $query->bindParam(6, $email, PDO::PARAM_STR);

	    if ($query->execute()) {    
	        header( "Location: frontend/reg.php?error=none");
	        exit();
	    }
	    else {
	        header( "Location: frontend/reg.php?error=qfail");
	        exit();
	    }

	} else {
  		header("Location: frontend/log.php");
  		exit();
	}



?>