<?php
    require "utils/utils.php";

    is_user_logged();
	
	$date = $_POST['date'];
	$hour = $_POST['hour'];
	$id = $_POST['id'];
	$motivation = $_POST['motivation'];
	
	UPDATE Evento SET Motivazione = $motivation, Stato = ‘’ WHERE (Id = $id);

    
	?>