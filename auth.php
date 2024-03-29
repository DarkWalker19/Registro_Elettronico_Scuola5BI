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
    $query = "SELECT Matricola, Nome, Cognome, Data_nascita, Tipo, U_Matricola FROM utente WHERE Matricola = ? AND Password = ?";
    
    $result = $db->prepare($query);
    $result->execute([$user, $password]);
    
    if($result->rowCount() == 0){
        error("wrong_credentials");
    }
    else{
        $row = $result->fetch();
        $_SESSION['user'] = $row['Matricola'];
        $_SESSION['name'] = $row['Nome'] . " " . $row['Cognome'];
        $_SESSION['role'] = $row['Tipo'];

        if(check_role('student')){
            $born_date = new DateTime($row['Data_nascita']);
            $today = new DateTime('now');

            $age = $today->diff($born_date);

            if(intval($age->format("%y")) >= 18)
                $_SESSION['adult'] = true;
            else
                $_SESSION['adult'] = false;
        }
        else if(check_role('parent'))
            $_SESSION['son'] = $row['U_Matricola'];
        
        header("Location: index.php");
    }
?>