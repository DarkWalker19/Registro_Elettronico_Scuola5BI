<?php
    require "utils/utils.php";

    is_user_logged();

	$db = get_PDO_connection();				
	
	if(!isset($_POST['id'])) error("invalid");

	$mode = $_POST['mode'];
	$id = $_POST['id'];
	$date = $_POST['date'];
	$hour = $_POST['hour'];
	$motivation = $_POST['motivation'];

	
	switch($mode){
		case 'm': //motivate
			if(!isset($_POST['date']) || !isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");
			if($_SESSION['adult'] || check_role('parent')){
				if(check_role('parent')){
					//prende la matricola dello studente minorenne
					$sonParentNumb = $SESSION['son'];

					//prende la matricola dello studente proprietario dell'evento se la matricola è la stessa della precedente
					$query = "SELECT U_Matricola FROM evento WHERE Id = ? AND U_Matricola = ?";
					$result = $db->prepare($query);
    				$result->execute([$id, $sonParentNumb]);

					if($result->rowCount() == 0){
						error("not_parent");
					}else{
						$query = "UPDATE evento SET Motivazione = ?, Stato = 'In attesa' WHERE (Id = ?)";
						$array = [$motivation, $id];
					}
				}else
					if($_SESSION['adult']){
						//prende la matricola dello studente proprietario dell'evento
						$query = "SELECT U_Matricola FROM evento WHERE Id = ? AND U_Matricola = ?";
						$result = $db->prepare($query);
						$result->execute([$id, $_SESSION['user']]);

						//verifica se la matricola dello studente in sessione e quella dello studente proprietario dell'evento combacino
						if($result->rowCount() == 0){
							error("not_owner");
						}else{
							$query = "UPDATE evento SET Motivazione = ?, Stato = 'In attesa' WHERE (Id = ?)";
							$array = [$motivation, $id];
						}
					}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'r': //remove
			if(check_role('admin')){
				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute([$id]);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user']]);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];

				//prende la classe di appartenenza dell'admin
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ? AND C_Id = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user'], $studentClass]);
			
				//verifica che la classe dell'admin in sessione combaci con quella dello studente proprietario dell'evento
				if($result->rowCount() == 0){
					error("not_same_class");
				}else{
					$query = "DELETE FROM evento WHERE (Id = ?)";
					$array = [$id];
				}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'a': //approve
			if(check_role('admin')){
				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute([$id]);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user']]);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];
				
				//prende la classe di appartenenza dell'admin
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ? AND C_Id = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user'], $studentClass]);

				if($result->rowCount() == 0){
					error("not_same_class");
				}else{
					$query = "UPDATE evento SET Stato = 'Accettato' WHERE (Id = ?)";
					$array = [$id];
				}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'd': //deny
			if(check_role('admin')){
				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute([$id]);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user']]);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];

				//prende la classe di appartenenza dell'admin
				$query = "SELECT C_Id FROM appartenere INNER JOIN classe ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ? AND C_Id = ?";
				$result = $db->prepare($query);
				$result->execute([$_SESSION['user'], $studentClass]);
				
				if($result->rowCount() == 0){
					error("not_same_class");
				}else{
					$query = "UPDATE evento SET Stato = 'Rifiutato' WHERE (Id = ?)";
					$array = [$id];
				}
			}else{
				error("insufficient_permission");
			}
		break;
	}
	
	try{
		$result = $db->prepare($query);
		$result->execute($array);
	}catch(PDOException $e){
		error("PDO_Query_Exception");
	}
	
	if(check_role("admin")){
		header("Location: agenda.php?section=s&mat=" . $_POST['matricola']);
		die();
	}
	else{
		header("Location: agenda.php?section=u");
		die();
	}
?>