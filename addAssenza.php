<?php
	require "utils/utils.php";

    is_user_logged();
	
	if(!isset($_POST['date'])) error("invalid");

	$date = $_POST['date'];
	
	$query = "INSERT INTO Evento (Data) VALUES ('$date');"
	
	$db = get_PDO_connection();
	
	$result = $db->prepare($query);
    $result->execute([$date]);

?>