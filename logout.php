<?php
	require_once "utils/utils.php";
    session_destroy();
    $_SESSION = null;
    $_COOKIE = null;
?>
<html>
    <head>
        <title>Logout</title>
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
		    <p>Hai fatto logout correttamente</p>
		    <p>Torna alla <button onclick="location.href='index.php'" type="button" class="btn btn-primary">Home</button></p>
        </div>
        <?php
            print_footer();
        ?>
    </body>
</html>