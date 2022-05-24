<?php
	require_once "utils/utils.php";

    is_user_logged();

	if(check_role("parent")||$_SESSION['adult']){
	
		if(!isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");

		$db = get_PDO_connection();
		$date = $_POST['date'];
		$hour = $_POST['hour'];
		$motivation = $_POST['motivation'];
		$numb = check_role("parent") ? $_SESSION['son'] : $_SESSION['user'];

		$query = "INSERT INTO evento (Stato, Data, Ora_uscita, Motivazione, Tipo, U_Matricola)";
		$query .= "VALUES (3, ?, ?, ?, 3, ?);";

		try{
			$result = $db->prepare($query);
			$result->execute([$date, $hour, $motivation, $numb]);
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}

	}else{
		error("insufficient_permission");
	}

	header("Location: agenda.php?section=u");
?>