<?php
	require "utils/utils.php";

    is_user_logged();
	
	if(!isset($_POST['date']) || !isset($_POST['hour']) || !isset($_POST['motivation'])) error("invalid");

	$date = $_POST['date'];
	$hour = $_POST['hour'];
	$motivation = $_POST['motivation'];
	
	$query = "INSERT INTO Evento (Data, Ora_uscita, Motivazione) VALUES ('$date', '$hour', '$motivation');"
	
	$db = get_PDO_connection();
	
	$result = $db->prepare($query);
    $result->execute([$id, $date, $motivation]);

?>