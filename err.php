<?php
	require_once "utils/utils.php";
?>
<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <?php
            print_header();
        ?>
        <div class="">
            <h1>Error</h1>
        </div>
        <div class="">
            <?php
                if(!isset($_GET['err']))
                    echo "No error provided";
                else{
                    $err = $_GET['err'];
                    echo "Error: $err";
                }
            ?>
        </div>
        <br>
        <p>Hai bisogno di aiuto? Contatta: rserci.s@itiscardanopv.edu.it</p>
        <br><br>
        <button onclick="location.href='index.php'" type="button" class="btn btn-primary">Indietro</button>
        <?php
            print_footer();
        ?>
    </body>
</html>