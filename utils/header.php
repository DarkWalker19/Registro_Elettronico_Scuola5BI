<!DOCTYPE html>

<html>
    <head>
        <?php
            require_once "utils.php";
            get_css();
        ?>
    </head>

    <body>
        <nav class="navbar navbar-light" style="background-color: #3366FF;">
            <div class="container-fluid">
                <a class="navbar-brand" style="color: white;" href="index.php">
                    <p>REGISTRO ELETTRONICO<br>
                        <i style="font-size: 10px">Itis G. Cardano</i>
                    </p>
                </a>
                <a href="https://www.itiscardanopv.edu.it/">
                    <img src="../img/logo.png" alt="LogoRegistro" height="60" width="60" border="2" align="right" hspace="10"></img>
                </a>
            </div>
        </nav>

        <?php

            if(!isset($_SESSION['user']) || $_SESSION['user'] == null){
                echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">';
                echo        '<div class="container-fluid">';
                echo            "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button>";
                echo        '</div>';
                echo    '</nav>';
            }else
                if(check_role("Student")){
                    echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">';
                    echo        '<div class="container-fluid">';
                    echo            '<div class="collapse navbar-collapse" id="navbarNav">';
                    echo                '<ul class="navbar-nav">';
                    echo                    '<li class="nav-item">';
                    echo                        '<a class="nav-link" style="color: white;" href = \'agenda.php?section=a\'>Assenze</a></li>';
                    echo                    '<li class="nav-item">';
                    echo                        '<a class="nav-link" style="color: white;" href = \'agenda.php?section=r\'>Ritardi</a></li>';            
                    echo                    '<li class="nav-item">';
                    echo                        '<a class="nav-link" style="color: white;" href = \'agenda.php?section=u\'>Uscite anticipate</a></li></ul>';
                    echo            '</div>';
                    echo        '</div>';        
                    echo        "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>";
                    echo     '</nav>';
                }else
                    if(check_role("Admin")){
                        echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">';
                        echo        '<div class="container-fluid">';
                        echo            '<div class="collapse navbar-collapse" id="navbarNav">';
                        echo                '<ul class="navbar-nav">';
                        echo                    '<li class="nav-item">';
                        echo                        '<a class="nav-link" style="color: white;" href = \'agenda.php?section=c\'>Le mie classi</a></li>';
                        echo            '</div>';
                        echo        '</div>';
                        echo        "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>";
                        echo     '</nav>';
                    }

        ?>
    </body>
</html>