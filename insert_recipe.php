<?php
	session_start();

	require_once("config.php");

if(isset($_POST["submit"])){
		require_once("config.php");


		$rName = htmlspecialchars($_POST["rName"]);
	    $tDiet = htmlspecialchars($_POST["dType"]);
	    $pTime = htmlspecialchars($_POST["pTime"]);
	    $ckTime = htmlspecialchars($_POST["ckTime"]);
	    $sSize = htmlspecialchars($_POST["sSize"]);


		if (empty($rName) || empty($tDiet) || empty($pTime) || empty($ckTime) || empty($sSize)) { 
			    header("Location:frontend/insertRec.php?error=emptyinput");
    			exit();
		} 


	   	$db = get_pdo_connection();





	    $query = $db->prepare("call insertRecipe(?,?,?,?,?)");
	    $query->bindParam(1, $pTime, PDO::PARAM_INT);
	    $query->bindParam(2, $ckTime, PDO::PARAM_INT);
	    $query->bindParam(3, $sSize, PDO::PARAM_INT);
	    $query->bindParam(4, $rName, PDO::PARAM_STR);
	    $query->bindParam(5, $tDiet, PDO::PARAM_STR);

	    if ($query->execute()) {    
	        header( "Location: frontend/insertRec.php?error=none");
	        exit();
	    }
	    else {
	        header( "Location: frontend/insertRec.php?error=qfail");
	        exit();
	    }

	} 

?>