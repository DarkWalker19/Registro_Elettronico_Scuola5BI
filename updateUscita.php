<?php
    require "utils/utils.php";

    is_user_logged();
	
	if(!isset($_POST['id']) || !isset($_POST['motivation'])) error("invalid_form");
	
	$mode = $_POST['mode'];
	$id = $_POST['id'];
	$motivation = $_POST['motivation'];
	
	switch($mode){
		case 'm': //motivate
			if($_SESSION['old'] || check_role['parent']{
				$query = "UPDATE Evento SET Motivazione = ?, Stato = 'In attesa' WHERE (Id = ?)";
				$array = [$motivation, $id];
			}else{
				error("insufficient_permission");
			}
			
		break;
		
		
		case 'r': //remove
			if(check_role('admin')){
				$query = "DELETE FROM Evento WHERE (Id = ?)";
				$array = [$id];
			}else{
				error("insufficient_permission");
			}
		break;
		
		
		case 'a': //approve
			if(check_role('admin')){
				$query = "UPDATE Evento SET  Stato = 'Giustificato' WHERE (Id = ?)"; //da sistemare
				$array = [$id];
			}else{
				error("insufficient_permission");
			}
		break;
		
		
		case 'd': //deny
			if(check_role('admin')){
				$query = "UPDATE Evento SET Stato = 'Rifiutato' WHERE (Id = ?)";//da fare
				$array = [$id];
			}else{
				error("insufficient_permission");
			}
		break;
	}
		
	$db = get_PDO_connection();
	
	try{
		$result = $db->prepare($query);
		$result->execute($array);
	}catch(PDOException $e){
		error("PDO_Query_Exception");
	}
	 
	?>