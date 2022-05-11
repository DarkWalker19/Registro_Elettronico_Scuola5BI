<?php
    require_once "utils/utils.php";
?>
<html>
    <head>
        <title>Login</title>
        <?php
			print_metadata();
            get_css();
        ?>
    </head>
    <body>
		<?php
			print_header();
		?>
        <form action="auth.php" method="POST" class="form">
			<div class="form-row">
				<h4>Accedi con le credenziali</h4><br>
				<div class="form-group col-md-6">
					<label for="inputMat">Matricola</label>
					<input style=background-color:#99ccff;width:10cm;type="text" class="form-control" placeholder="Inserisci Matricola" id="m"></input>
				</div>
				<div class="form-group col-md-6">
					<label for="inputPass">Password</label>
					<input style=background-color:#99ccff;width:10cm; type="password" class="form-control" placeholder="Inserisci Password" id="p"></input>
				</div><br>
				<?php
					$_SESSION['captcha'] = generate_captcha();
				?> 
				<br><button type="submit" class="btn btn-primary">Login</button><br> 
			</div>   
        </form>
		<?php
			print_footer();
		?>
    </body>
</html>