<?php
    require "utils/utils.php";

    is_user_logged();
	
	
	if(!isset($_POST['id']) || !isset($_POST['date']) || !isset($_POST['motivation'])) error("invalid");
	
	$mode = $_POST['mode'];
	$id = $_POST['id'];
	$date = $_POST['date']; // in dubbio
	$motivation = $_POST['motivation'];
	
	switch($mode){
		case 'm': //motivate
		$query = "UPDATE Evento SET Motivazione = '$motivation' WHERE (Id = '$id')";
		break;
		
		case 'r': //remove
		$query = "DELETE FROM Evento WHERE (Id = '$id')";
		break;
		
		case 'a': //approve
		$query = "UPDATE Evento SET  Stato = '$state' WHERE (Id = '$id')"; //da sistemare
		break;
		
		case 'd': //deny
		//da fare
		break;
	}
	
	/*if(!check_role("admin")){
		$state = "In attesa";
	}else{
		$state = "Giustificato";
	}*/
	
	$db = get_PDO_connection();
	
	//$query = "UPDATE Evento SET Motivazione = $motivation, Stato = $state WHERE (Id = $id)";
	
	$result = $db->prepare($query);
    $result->execute([$id, $date, $motivation]);

    
	?>