<?php
	require_once "utils/utils.php";
?>
<html>
    <head>
        <title>Error</title>
        <?php
            print_metadata();
            get_css();
        ?>
    </head>
    <body>
        <?php
            print_header();
        ?>
        <div style='position: relative; margin-top: 1%; margin-left: 35%; margin-bottom: 30%; margin-right: 35%;'>
            <h1>Error</h1>
            <?php
                if(!isset($_GET['err']))
                    echo "No error provided";
                else{
                    $err = $_GET['err'];
                    echo "Error: $err";
                }
            ?>
        <br>
        <p>Hai bisogno di aiuto? Contatta: rserci.s@itiscardanopv.edu.it</p>
        <br><br>
        <button onclick="location.href='index.php'" type="button" class="btn btn-primary">Indietro</button>
        </div>
        <?php
            print_footer();
        ?>
    </body>
</html>