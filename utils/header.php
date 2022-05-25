<?php
    require_once "utils.php";
?>

<html>
    <head>
    </head>

    <body>
        <nav class="navbar navbar-light titleNavbarBackground">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <p class="_hTitle">LIBRETTO ELETTRONICO<br>
                        <i class="sText">Itis G. Cardano</i>
                    </p>
                </a>
                <a href="https://www.itiscardanopv.edu.it/">
                    <img class="logo" src="./img/logo.png" alt="LogoRegistro"></img>
                </a>
            </div>
        </nav>

        <?php

            if(!isset($_SESSION['user'])){
                echo    '<nav class="navbarBackground navbar navbar-expand-lg">
                            <div class="container-fluid divLoginButton">';
                echo            "<button class=\"btn btn-primary customButton\" onclick=\"location.href='login.php'\" type=\"button\">Login</button>
                            </div>
                        </nav>";
            }else
                if(!check_role('admin')){
                    echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF; display: flex; justify-content: flex-end">
                                <div class="container-fluid">
                                    
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link divLink" href = \'agenda.php?section=a\'>Assenze</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link divLink" href = \'agenda.php?section=r\'>Ritardi</a>
                                            </li>           
                                            <li class="nav-item">
                                                <a class="nav-link divLink" href = \'agenda.php?section=u\'>Uscite anticipate</a>
                                            </li>
                                        </ul>
                                    
                                </div>';        
                    echo            "<button class=\"btn btn-primary customButton\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                }else{
                    echo    '<nav class="navbar navbar-expand-lg " style="background-color: #6699FF; display: flex; justify-content: flex-end;">
                                <div class="container-fluid">
                                   
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link divLink" href = \'agenda.php?section=c\'>Le mie classi</a>
                                            </li>
                                    
                                </div>';
                    echo            "<button class=\"btn btn-primary customButton\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                    }

        ?>
    </body>
</html>