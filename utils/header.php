<?php
    require_once "utils.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <?php
            print_metadata();
            get_css();
        ?>
    </head>

    <body>
        <nav class="navbar navbar-light" style="background-color: #3366FF;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <p style="color: white; font-size: 25px">LIBRETTO ELETTRONICO<br>
                        <i style="font-size: 10px">Itis G. Cardano</i>
                    </p>
                </a>
                <a href="https://www.itiscardanopv.edu.it/">
                    <img src="./img/logo.png" alt="LogoRegistro" height="60" width="60" border="2" align="right" hspace="10"></img>
                </a>
            </div>
        </nav>

        <?php

            if(!isset($_SESSION['user'])){
                echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">
                            <div align="right" class="container-fluid">';
                echo            "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='login.php'\" type=\"button\">Login</button>
                            </div>
                        </nav>";
            }else
                if(!check_role('admin')){
                    echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">
                                <div class="container-fluid">
                                    <div class="collapse navbar-collapse" id="navbarNav">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" style="color: white;" href = \'agenda.php?section=a\'>Assenze</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" style="color: white;" href = \'agenda.php?section=r\'>Ritardi</a>
                                            </li>           
                                            <li class="nav-item">
                                                <a class="nav-link" style="color: white;" href = \'agenda.php?section=u\'>Uscite anticipate</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';        
                    echo            "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                }else{
                    echo    '<nav class="navbar navbar-expand-lg" style="background-color: #6699FF">
                                <div class="container-fluid">
                                    <div class="collapse navbar-collapse" id="navbarNav">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" style="color: white;" href = \'agenda.php?section=c\'>Le mie classi</a>
                                            </li>
                                    </div>
                                </div>';
                    echo            "<button class=\"btn btn-primary\" style=\"background-color: #98CCFF;\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                    }

        ?>
    </body>
</html>