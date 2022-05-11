<?php
    require_once "utils/utils.php";
    

    if(!isset($_POST['id']) || !isset($_POST['password']) || !isset($_POST['captcha'])) error("invalid_login_form");
    
    $user = $_POST['id'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    
    if($captcha!=$_SESSION['captcha']){
        session_destroy();
        error("invalid_captcha");
    }

    $db = get_PDO_connection();
    $query = "SELECT Matricola, Nome, Cognome, Data_nascita, Tipo FROM utente WHERE Matricola = $user AND Password = $password;";
    
    $result = $db->prepare($query);
    $result->execute([$user, $password]);
    
    if($result->rowCount() == 0){
        error("wrong_credentials");
    }
    else{
        $row = $result->fetch();
        $_SESSION['user'] = $row[0];
        $_SESSION['name'] = $row[1] . " " . $row[2];
        $_SESSION['role'] = $row[4];

        if(check_role('student')){
            if(date_diff(date_create($row[3]), date_create(date("dd-mm-YY")))->format("%y") >= 18)
                $_SESSION['adult'] = true;
            else
                $_SESSION['adult'] = false;
        }
        header("Location: index.php");
    }
?>