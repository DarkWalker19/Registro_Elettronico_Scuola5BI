<?php
    require "./utils/utils.php";
?>
<html>
    <head>
        <title>Login</title>
        <?php
            get_css();
        ?>
    </head>
    <body>
        <form action="auth.php" method="POST" class="form">
           
			<br>
			<label for="matricola">Matricola</label>
			<input type="text" placeholder="Inserisci matricola" name="matricola" required>
			<br>
			<label for="password">Password</label>
			<input type="password" placeholder="Inserisci password" name="password" required>
			<br><br>
			<?php
				$code = generate_field();
				$_SESSION['captcha'] = $code;
			?>
			<br><br>
			<button type="submit">Login</button>
			<p><a href="register.php">Registrati</a></p>
                
        </form>
    </body>
</html>