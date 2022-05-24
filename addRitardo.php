<?php
	require_once "utils/utils.php";

    is_user_logged();

	if(check_role("parent") || $_SESSION['adult']){
	
		if(!isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");

		$db = get_PDO_connection();
		$hour = $_POST['hour'];
		$motivation = $_POST['motivation'];
		$numb = $_POST['matricola'];
		
		$query = "INSERT INTO Evento (Stato, Data, Ora_entrata, Motivazione, Tipo, U_Matricola)";
		$query .= "VALUES (4, CURRDATE(), ?, ?, 2, ?);";
		
		try{
			$result = $db->prepare($query);
			$result->execute([$hour,$motivation,$numb]);	
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}

	}else{
		error("insufficient permission");
	}
?>