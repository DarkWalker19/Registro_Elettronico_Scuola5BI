<?php
	require_once "utils/utils.php";

    is_user_logged();

	if(check_role("parent") || $_SESSION['old']){
	
		if(!isset($_POST['data']) || !isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");

		$db = get_PDO_connection();
		$date = $_POST['date'];
		$hour = $_POST['hour'];
		$motivation = $_POST['motivation'];
		$numb = $_POST['matricola'];
		
		$query = "INSERT INTO Evento (Stato,Data,Ora_entrata,Motivazione,Tipo,U_Matricola)";
		$query .= "VALUES ('4',?,?,?,'2',?);";
		
		try{
			$result = $db->prepare($query);
			$result->execute([$date,$hour,$motivation,$numb]);	
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}

	}else{
		error("insufficient permission");
	}
?>