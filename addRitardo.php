<?php
	require_once "utils/utils.php";

    is_user_admin();

	if(!isset($_POST['hour'])) error("invalid");

	$db = get_PDO_connection();
	$hour = $_POST['hour'];
	$motivation = $_POST['motivation'];
	$numb = $_POST['matricola'];

	//verifica se è presente un evento assenza su un determinato studente
	$query = "SELECT U_Matricola, Id FROM evento WHERE Data = CURRENT_DATE AND Tipo == 'Assenza' AND U_Matricola = '$numb'";
	$result = $db->query($query);

	if($result->rowCount() < 0){
		$row = $result->fetchAll();
		//se c'è lo rimuove
		$query = "DELETE FROM evento WHERE U_Matricola = ? AND Id = ?";

		try{
			$result = $db->prepare($query);
			$result->execute([$numb, $row['Id']]);	
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}
	}else{
		//verifica se è presente un evento ritardo su un determinato studente
		$query = "SELECT U_Matricola, Id FROM evento WHERE Data = CURRENT_DATE AND Tipo == 'Ritardo' AND U_Matricola = '$numb'";
		$result = $db->query($query);

		if($result->rowCount() < 0){
			error("event_already_exists");
		}else{
			$query = "INSERT INTO evento (Stato, Data, Ora_entrata, Motivazione, Tipo, U_Matricola)";
			$query .= "VALUES (4, CURRENT_DATE, ?, ?, 2, ?);";

			try{
				$result = $db->prepare($query);
				$result->execute([$hour,$motivation,$numb]);	
			}catch(PDOException $e){
				error("PDO_QUERY_Exception");
			}
		}
	}
?>