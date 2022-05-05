<?php
    require_once "utils.php";
    get_css();
?>

<!DOCTYPE html>

<html>
    <head></head>

    <body>
        <nav class="navbar navbar-light" style="background-color: #3366FF;">
        <div class="container-fluid">
        <a class="navbar-brand" style="color: white;" href="index.php">Registro Elettronico</a>
        <a href="https://www.itiscardanopv.edu.it/">
            <img src="img/logo.jpg" alt="LogoRegistro" height="60" width="60" border="2" align="right" hspace="10"></img>
        </a>
    </nav>

    <?php
<<<<<<< Updated upstream
        if(!isset($_SESSION['user'])){
            echo '<nav class="navbar navbar-expand-lg" style="background-color: #f0e68c">';
            echo "<button onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button></nav>";
        }else{
            echo '<nav class="navbar navbar-expand-lg" style="background-color: #f0e68c">';
=======
        //if(!isset($_SESSION['user']) || $_SESSION['user'] == null){
            //echo '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">';
            //echo "<button onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button></nav>";
        //}else{
            echo '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">';
            echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
            echo '<span class="navbar-toggler-icon"></span></button>';
>>>>>>> Stashed changes
            echo    '<div class="collapse navbar-collapse" id="navbarNav">';
            echo        '<ul class="navbar-nav">';
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href = \'agenda.php?section=a\'>Assenze</a></li>';
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href = \'agenda.php?section=r\'>Ritardi</a></li>';            
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href = \'agenda.php?section=u\'>Uscite anticipate</a></li></ul></div>';
            echo    "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button></nav>";
        //}
    ?>
    
</html>