<html>
    <head>
        <title>AGENDA</title>
        <meta charset="UTF-8">
        <meta name="Descrizione" content="Agenda">
        <meta name="Linguaggi" content="HTML, CSS, JavaScript">
        <meta name="Autore" content="Gruppo 3">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"></link>
    </head>

    <body>
            <nav class="navbar navbar-light" style="background-color: #FFD700;">
                    <div>
                        <h1>REGISTRO ELETTRONICO</h1>
                    </div>
                    <img src="IMG/logo.jpg" alt="LogoRegistro" height="60" width="60" border="2" align="right" hspace="10"></img>
            </nav>

            <?php

            //if($_SESSION('tipo')=="Alunno"||$_SESSION('tipo')=="Genitore"){
                echo '<nav class="navbar navbar-expand-lg" style="background-color: #f0e68c">';
                echo    '<div class="collapse navbar-collapse" id="navbarNav">';
                echo        '<ul class="navbar-nav">';
                echo            '<li class="nav-item">';
                echo                '<a class="nav-link" href="#">Giustifica Assenze</a></li>';
                echo            '<li class="nav-item">';
                echo                '<a class="nav-link" href="#">Giusifica Ritardi</a></li>';            
                echo            '<li class="nav-item">';
                echo                '<a class="nav-link" href="#">Richiedi uscita anticipata</a></li></ul></div>';
                echo    "<button onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button></nav>";
            //}else
             /*   if($_SESSION('tipo')=="Admin"){
                    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #FFFF66">';
                    echo    '<div class="collapse navbar-collapse" id="navbarNav">';
                    echo        '<ul class="navbar-nav">';
                    echo            '<li class="nav-item">';
                    echo                '<a class="nav-link" href="#">Le mie classi</a></li>'</ul></div>';
                    echo    "<button onclick=\"location.href='login.php'\" type=\"button\" align=\"right\" hspace=\"10\">Login</button></nav>";

                }*/

                echo '<div style="background-color: #ffffe0"></div>';
           

            ?>
    </body>


</html>