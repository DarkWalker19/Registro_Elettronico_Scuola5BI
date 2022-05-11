<?php
    require_once "utils/utils.php";
?>
<!doctype html>
<html lang="it">
    <head>
        <?php
            print_header();
            get_css();
        ?>
  
        <title>Pagina Iniziale</title>
    </head>
    <body>
        <?php
            if((!isset($_SESSION['Name'])) || ($_SESSION['Name'] == null)){
                echo "<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";
                echo "<h4>Non sei loggato, accedi tramite il bottone LOGIN per poter continuare!</h4>";
                echo "<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";echo"<br>";
            }else{
                echo "<p>Benvenuto". " " .$_SESSION['Name'];
            }
            print_footer();
        ?>
    </body>
</html>
