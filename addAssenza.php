<?php
	require_once "utils/utils.php";

	is_user_admin();

	if(!isset($_POST['matricola']))
		error("invalid");

	$db = get_PDO_connection();
	$numb = $_POST['matricola'];

	//verifica se è presente un evento su un determinato studente
	$query = "SELECT U_Matricola FROM evento WHERE Data != CURRENT_DATE AND Tipo != 'Uscita Anticipata'";
	$result = $db->prepare($query);
    $result->execute();

	if($result->rowCount() == 0){
		error("not_same_class");
	}else{
		$query = "INSERT INTO evento (Stato, Data, Tipo, U_Matricola)";
		$query .= "VALUES (4, CURRENT_DATE, 1, ?)";
		try{
			$result = $db->prepare($query);
			$result->execute([$numb]);
		}catch(PDOException $e){
			error("PDO_QUERY_Exception");
		}
	}
?>