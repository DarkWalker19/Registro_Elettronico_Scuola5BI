<?php
    require_once "utils/utils.php";

    is_user_logged();

	$db = get_PDO_connection();
	
	if(!isset($_POST['id'])) error("invalid");
	
	$mode = $_POST['mode'];
	$id = $_POST['id'];
	$date = $_POST['data'];
	$motivation = $_POST['motivazione'];
	

	switch($mode){
		case 'm': //motivate
			if(!isset($_POST['motivation'])) error("invalid");
			if($_SESSION['adult'] || check_role('parent')){
				if(check_role('parent')){
					//prende la matricola dello studente minorenne
					$sonParentNumb = $SESSION['son'];

					//prende la matricola dello studente proprietario dell'evento
					$query = "SELECT U_Matricola FROM evento WHERE Id = ?";
					$result = $db->prepare($query);
    				$result->execute($id);
    
					$row = $result->fetch();
					$eventStudentNumb = $row['U_Matricola'];

					//verifica se la matricola dello studente minorenne e quella dello studente proprietario dell'evento combacino
					if($sonParentNumb==$eventStudentNumb){
						$query = "UPDATE Evento SET Motivazione = ?, Stato = 'In attesa' WHERE (Id = ?)";
						$array = [$motivation, $id];
					}else{
						error("not_parent");
					}
				}else
					if($_SESSION['adult']){
						//prende la matricola dello studente proprietario dell'evento
						$query = "SELECT U_Matricola FROM evento WHERE Id = ?";
						$result = $db->prepare($query);
						$result->execute($id);
		
						$row = $result->fetch();
						$eventStudentNumb = $row['U_Matricola'];

						//verifica se la matricola dello studente in sessione e quella dello studente proprietario dell'evento combacino
						if($_SESSION['user']==$eventStudentNumb){
							$query = "UPDATE Evento SET Motivazione = ?, Stato = 'In attesa' WHERE (Id = ?)";
							$array = [$motivation, $id];
						}else{
							error("not_owner");
						}
					}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'r': //remove
			if(!isset($_POST['motivation'])) error("invalid");
			if(check_role('admin')){
				//prende la classe di appartenenza dell'admin
				$query = "SELECT U_Matricola, C_Id FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$adminClass = $row['C_Id'];

				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute($id);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT U_Matricola, C_Id, FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];
				
				//verifica che la classe dell'admin in sessione combaci con quella dello studente proprietario dell'evento
				if($adminClass == $studentClass){
					$query = "DELETE FROM Evento WHERE (Id = ?)";
					$array = [$id];
				}else{
					error("not_same_class");
				}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'a': //approve
			if(!isset($_POST['motivation'])) error("invalid");
			if(check_role('admin')){
				//prende la classe di appartenenza dell'admin
				$query = "SELECT U_Matricola, C_Id FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$adminClass = $row['C_Id'];

				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute($id);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT U_Matricola, C_Id, FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];

				if($adminClass == $studentClass){
					$query = "UPDATE Evento SET  Stato = 'Giustificato' WHERE (Id = ?)";
					$array = [$id];
				}else{
					error("not_same_class");
				}
			}else{
				error("insufficient_permission");
			}
			break;
		
		case 'd': //deny
			if(!isset($_POST['motivation'])) error("invalid");
			if(check_role('admin')){
				//prende la classe di appartenenza dell'admin
				$query = "SELECT U_Matricola, C_Id FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$adminClass = $row['C_Id'];

				//prende la matricola dello studente proprietario dell'evento
				$query = "SELECT U_Matricola FROM evento WHERE (Id = ?)";
				$result = $db->prepare($query);
				$result->execute($id);

				$row = $result->fetch();
				$studentNumb = $row['U_Matricola'];

				//prende la classe dello studente
				$query = "SELECT U_Matricola, C_Id, FROM appartenere INNER JOIN classi ON (appartenere.C_Id = classe.Id) WHERE U_Matricola = ?";
				$result = $db->prepare($query);
				$result->execute($_SESSION['user']);

				$row = $result->fetch();
				$studentClass = $row['C_Id'];

				if($adminClass == $studentClass){
					$query = "UPDATE Evento SET Stato = 'Rifiutato' WHERE (Id = ?)";
					$array = [$id];
				}else{
					error("not_same_class");
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

	?>