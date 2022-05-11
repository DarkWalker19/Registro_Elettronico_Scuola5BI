<?php
	require_once "utils/utils.php";
    session_destroy();
?>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
        <?php
            print_header();
        ?>
		<p>Hai fatto logout correttamente</p>
		<p>Torna alla <button onclick="location.href='index.php'" type="button" class="backButton">Home</button></p>
        <?php
            print_footer();
        ?>
    </body>
</html>