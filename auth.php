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
    $query = "SELECT Matricola, Nome, Cognome, Data_nascita, Tipo FROM utente WHERE Matricola = ? AND Password = ?";
    
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
            $born_date = new DateTime($row[3]);
            $today = new DateTime('now');
            
            $age = $today->diff($born_date);

            if(intval($age->format("%y")) >= 18)
                $_SESSION['adult'] = true;
            else
                $_SESSION['adult'] = false;
        }
        header("Location: index.php");
    }
?>