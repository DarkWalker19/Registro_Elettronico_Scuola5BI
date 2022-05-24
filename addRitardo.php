<?php
	require_once "utils/utils.php";

    is_user_admin();

	if(!isset($_POST['hour'])) error("invalid");

	$db = get_PDO_connection();
	$hour = $_POST['hour'];
	$motivation = $_POST['motivation'];
	$numb = $_POST['matricola'];
	
	$query = "INSERT INTO evento (Stato, Data, Ora_entrata, Motivazione, Tipo, U_Matricola)";
	$query .= "VALUES (4, CURRENT_DATE, ?, ?, 2, ?);";
	
	try{
		$result = $db->prepare($query);
		$result->execute([$hour,$motivation,$numb]);	
	}catch(PDOException $e){
		error("PDO_QUERY_Exception");
	}
?>