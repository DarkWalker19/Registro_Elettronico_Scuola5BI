<?php
	require_once "utils/utils.php";

    is_user_admin();

	if(!isset($_POST['hour'])) error("invalid");

	$db = get_PDO_connection();
	$hour = $_POST['hour'];
	$motivation = $_POST['motivation'];
	$numb = $_POST['matricola'];

	//verifica se è presente un evento assenza su un determinato studente
	$query = "SELECT Id FROM evento WHERE Data = CURRENT_DATE AND Tipo != 'Uscita' AND U_Matricola = ?";
	$result = $db->prepare($query);
	$result->execute([$numb]);	

	if($result->rowCount() > 0){
		$row = $result->fetch();

		//se c'è lo rimuove
		$query = "DELETE FROM evento WHERE Id = ?";

		try{
			$result = $db->prepare($query);
			$result->execute([$row['Id']]);	
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}
	}

	$query = "INSERT INTO evento (Stato, Data, Ora_entrata, Motivazione, Tipo, U_Matricola)";
	$query .= "VALUES (4, CURRENT_DATE, ?, ?, 2, ?);";

	try{
		$result = $db->prepare($query);
		$result->execute([$hour,$motivation,$numb]);	
	}catch(PDOException $e){
		error("PDO_QUERY_Exception");
	}

	header("Location: agenda.php?section=c&class=" . $_POST['class']);
	die();
?>