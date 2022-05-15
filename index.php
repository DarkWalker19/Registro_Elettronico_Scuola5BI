<?php
    require_once "utils/utils.php";
?>
<html>
    <head>
        <title>Pagina Iniziale</title>
        <?php
            print_metadata();
            get_css();
        ?>
    </head>
    <body>
        <?php
            print_header();
            if((!isset($_SESSION['name'])) || ($_SESSION['name'] == null)){
                echo "<div style = \"width: 50%; height: 50%;\">
                        <div style = \"position:absolute; margin-left: 35%; margin-top: 10%; margin-bottom: 10%; margin-right:35%\">
                            <h4>Non sei loggato! Clicca <b>Login</b> in alto per accedere.</h4>
                        </div>
                    </div>";
            }else{
                echo "<div style = \"width: 50%; height: 50%;\">
                        <div style = \"position:absolute; margin-left: 40%; margin-top: 10%\">
                            <h4>Benvenuto". " " . "<i>" . $_SESSION['name'] . "</i></h4>
                        </div>
                    </div>";
            }
            print_footer();
        ?>
    </body>
</html>
