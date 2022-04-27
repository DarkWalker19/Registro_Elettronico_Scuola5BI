<!DOCTYPE html>

<html>
    <head>
        <nav class="navbar navbar-light" style="background-color: #FFD700;">
    </head>

    <body>
        <div><h1>REGISTRO ELETTRONICO</h1></div>
        <img src="IMG/logo.jpg" alt="LogoRegistro" height="60" width="60" border="2" align="right" hspace="10"></img>
    </nav>

    <?php
        if(!isset($_SESSION['user'] || $_SESSION['user'] == null)){
            echo '<nav class="navbar navbar-expand-lg" style="background-color: #f0e68c">';
            echo "<button onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button></nav>";
        }else{
            echo '<nav class="navbar navbar-expand-lg" style="background-color: #f0e68c">';
            echo    '<div class="collapse navbar-collapse" id="navbarNav">';
            echo        '<ul class="navbar-nav">';
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href="#">Assenze</a></li>';
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href="#">Ritardi</a></li>';            
            echo            '<li class="nav-item">';
            echo                '<a class="nav-link" href="#">Uscita anticipate</a></li></ul></div>';
            echo    "<button onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button></nav>";
        }
    ?>
    
</html>