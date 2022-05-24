<?php
	require_once "utils/utils.php";

    is_user_logged();

	if(check_role("parent")||$_SESSION['adult']){
	
		if(!isset(!isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");

		$db = get_PDO_connection();
		$hour = $_POST['hour'];
		$motivation = $_POST['motivation'];
		$numb = $_POST['matricola'];
		
		$query = "INSERT INTO evento (Stato, Data, Ora_uscita, Motivazione, Tipo, U_Matricola)";
		$query .= "VALUES (4, CURRENT_DATE, ?, ?, 3, ?);";

		try{
			$result = $db->prepare($query);
			$result->execute([$hour, $motivation, $numb]);
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}

	}else{
		error("insufficient_permission");
	}
?>