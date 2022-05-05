<?php
    require "./utils/utils.php";
    

    if(!isset($_POST['matricola']) || !isset($_POST['password']) || !isset($_POST['captcha'])) error("invalid_login_form");
    
    $user = $_POST['matricola'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    
    if($captcha!=$_SESSION['captcha']){
        session_destroy();
        error("invalid_captcha");
    }

    $db = get_db_connection();
    $query = "SELECT matricola, nome, cognome, password FROM bar_user WHERE matricola = $user AND password = $password;";
    
    $result = $db->prepare($query);
    $result->execute([$user, $password]);
    
    if($result->rowCount() == 0){
        error("wrong_credentials");
    }
    else{
        $row = $result->fetch();
        $_SESSION['user_id'] = $row[0];
        $_SESSION['user'] = $user;
        
        header("Location: index.php");
    }
?>