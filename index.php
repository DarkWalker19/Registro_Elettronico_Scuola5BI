<?php
    require_once "utils/utils.php";
?>
<html>
    <head>
        <title>Pagina Iniziale</title>
    </head>
    <body>
        <?php
            print_header();
            if((!isset($_SESSION['name'])) || ($_SESSION['name'] == null)){
                echo "<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";
                echo "<h4>Non sei loggato, accedi tramite il bottone LOGIN per poter continuare!</h4>";
                echo "<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";
            }else{
                echo "<p>Benvenuto". " " .$_SESSION['name'];
            }
            print_footer();
        ?>
    </body>
</html>