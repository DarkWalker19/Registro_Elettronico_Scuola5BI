<?php
	require_once "utils/utils.php";
    session_destroy();
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
       
		<p>Hai fatto logout correttamente</p>
		<p>Torna alla <button onclick="location.href='index.php'" type="button" class="backButton">Home</button></p>
        
    </body>
</html>