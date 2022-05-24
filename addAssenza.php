<?php
	require_once "utils/utils.php";

	is_user_admin();

	if(!isset($_POST['matricola']))
		error("invalid");

	$db = get_PDO_connection();
	$numb = $_POST['matricola'];

	$query = "INSERT INTO Evento (Stato, Data, Tipo, U_Matricola)";
	$query .= "VALUES (4, CURRDATE(), 1, ?)";
	
	try{
		$result = $db->prepare($query);
		$result->execute([$date, $numb]);
	}catch(PDOException $e){
		error("PDO_QUERY_Exception");
	}
?>