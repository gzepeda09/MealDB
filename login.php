<?php 
	session_start();

	

	if(isset($_POST["submit"])){

		require_once("config.php");

		$email = htmlspecialchars($_POST["email"]);
	    $pwd = htmlspecialchars($_POST["password"]);

		if (empty($email) || empty($pwd)) { 
			    header("Location:frontend/log.php?error=emptyinput");
				exit();
		} 

		$db = get_pdo_connection();

	    // get users info from email
	    $query = $db->prepare("SELECT * FROM registeredUsers WHERE email = ?");
		$query->bindParam(1, $email, PDO::PARAM_STR);
		$results;
		if($query->execute()){

			$results = $query->fetchAll(PDO::FETCH_ASSOC);

		} else {
			header("Location: frontend/log.php?error=qfail");
			exit();
		}

		if (count($results) == 0) {
	        // no user found with the given email
	        header("Location: frontend/log.php?error=userNotFound");
	        exit();
    	} else {
    		$_SESSION['isPrem'] = $results[0]['isPrem'];
    		$_SESSION['email'] = $results[0]['email'];
    	}

		$hashedPass = $results[0]["password"];



		$verifyPassword = password_verify($pwd, $hashedPass);

  		if($verifyPassword === false) {
    		header("Location: frontend/log.php?error=mismatchPasswords");
    		exit(); 
  		} else if($verifyPassword === true) {
		    $_SESSION['userID'] = $results[0]["UserID"];
		    $_SESSION['email'] = $results[0]["email"];

		    header("Location: frontend/userProf.php");
		    exit();
		}
	} else{
		header("Location: frontend/reg.php");
		exit();
	}










?>