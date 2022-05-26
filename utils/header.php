<?php
    require_once "utils.php";
?>

<html>
    <head>
    </head>

    <body>
        <nav class="navbar navbar-light _bkg1">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <p class="_title">LIBRETTO ELETTRONICO<br>
                        <i class="_subtitle">Itis G. Cardano</i>
                    </p>
                </a>
                <a href="https://www.itiscardanopv.edu.it/">
                    <img src="./img/logo.png" alt="LogoRegistro" class="_logo"></img>
                </a>
            </div>
        </nav>

        <?php

            if(!isset($_SESSION['user'])){
                echo    '<nav class="navbar navbar-expand-lg _bkg2">
                            <div class="container-fluid _login-btn">';
                echo            "<button class=\"btn btn-primary _bkg3\" onclick=\"location.href='login.php'\" type=\"button\">Login</button>
                            </div>
                        </nav>";
            }else
                if(!check_role('admin')){
                    echo    '<nav class="navbar navbar-expand-lg _bkg2 _nav-style">
                                <div class="container-fluid">
                                    
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link _menu-text-color" href = \'agenda.php?section=a\'>Assenze</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link _menu-text-color" href = \'agenda.php?section=r\'>Ritardi</a>
                                            </li>           
                                            <li class="nav-item">
                                                <a class="nav-link _menu-text-color" href = \'agenda.php?section=u\'>Uscite anticipate</a>
                                            </li>
                                        </ul>
                                    
                                </div>';        
                    echo            "<button class=\"btn btn-primary _bkg3\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                }else{
                    echo    '<nav class="navbar navbar-expand-lg _bkg2 _nav-style">
                                <div class="container-fluid">
                                   
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link _menu-text-color" href = \'agenda.php?section=c\'>Le mie classi</a>
                                            </li>
                                    
                                </div>';
                    echo            "<button class=\"btn btn-primary _bkg3\" onclick=\"location.href='logout.php'\" type=\"button\" align=\"right\" hspace=\"10\">Logout</button>
                            </nav>";
                    }

        ?>
    </body>
</html>