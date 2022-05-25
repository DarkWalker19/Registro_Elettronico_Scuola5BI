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
                echo "<div style='position: relative; margin-top: 1%; margin-left: 35%; margin-bottom: 30%; margin-right: 35%;'>
                        <h4 style='text-align: center'>Non sei loggato! Clicca <b>Login</b> in alto per accedere.</h4>
                    </div>";
            }else{
                echo "<div style='position: relative; margin-top: 1%; margin-left: 35%; margin-bottom: 30%; margin-right: 35%;'>
                        <h4 style='text-align: center'>Benvenuto". " " . "<i>" . $_SESSION['name'] . "</i></h4>
                    </div>";
            }
            print_footer();
        ?>
    </body>
</html>