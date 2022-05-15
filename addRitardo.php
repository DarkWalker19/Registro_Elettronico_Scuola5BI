<?php
	require "utils/utils.php";

    is_user_logged();
	
	if(!isset($_POST['date']) || !isset($_POST['hour'])) error("invalid");

	$date = $_POST['date'];
	$hour = $_POST['hour'];
	
	$query = "INSERT INTO Evento (Data, Ora_entrata) VALUES ('$date', '$hour');"
	
	$db = get_PDO_connection();
	
	$result = $db->prepare($query);
    $result->execute([$date,$hour]);

?>