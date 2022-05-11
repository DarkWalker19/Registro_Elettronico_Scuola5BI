<?php
    require_once "utils/utils.php";
    

    if(!isset($_POST['matricola']) || !isset($_POST['password']) || !isset($_POST['captcha'])) error("invalid_login_form");
    
    $user = $_POST['matricola'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    
    if($captcha!=$_SESSION['captcha']){
        session_destroy();
        error("invalid_captcha");
    }

    $db = get_PDO_connection();
    // è inutile prendere gli altri parametri.
    // prendi matricola nome cognome data nascita
    $query = "SELECT matricola, nome, cognome, password FROM bar_user WHERE matricola = $user AND password = $password;";
    
    $result = $db->prepare($query);
    $result->execute([$user, $password]);
    
    if($result->rowCount() == 0){
        error("wrong_credentials");
    }
    else{
        $row = $result->fetch();
        $_SESSION['user'] = $user;
        // aggiungere controllo se è studente se è adulto
        // session name = nome spazio cognome
        header("Location: index.php");
    }
?>