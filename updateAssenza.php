<?php
    require "utils/utils.php";

    is_user_logged();
	
	
	if(!isset($_POST['id']) || !isset($_POST['date']) || !isset($_POST['motivation'])) error("invalid");
	
	$id = $_POST['id'];
	$date = $_POST['date'];
	$motivation = $_POST['motivation'];
	
	if(!check_role("admin")){
		$state = "In attesa";
	}else{
		$state = "Giustificato";
	}
	
	$db = get_PDO_connection();
	
	$query = "UPDATE Evento SET Motivazione = $motivation, Stato = $state WHERE (Id = $id)";
	
	$result = $db->prepare($query);
    $result->execute([$id, $date, $motivation]);

    
	?>