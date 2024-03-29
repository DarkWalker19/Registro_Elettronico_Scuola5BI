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
		<script>
        	function _togglePassword(){ 
				let pwd = document.getElementById("password");
				if (pwd.type === "password") pwd.type = "text";
				else pwd.type = "password";
				
				let togglePassword = document.getElementById("togglePassword");
				togglePassword.classList.toggle("bi-eye");
			}
		</script>
		
    </head>
    <body>
		<?php
			print_header();
		?>
        <form action="auth.php" method="POST" class="form _table-margins">
			<div class="form-row" align="center">
				<h4>Accedi con le credenziali</h4><br>
				<div class="form-group col-md-6">
					<label for="id">Matricola</label>
					<input class="form-control _input-field" type="text" class="form-control" placeholder="Inserisci Matricola" id="id" name="id"></input>
				</div>
				<div class="form-group col-md-6">
					<label for="password">Password</label>
					<input class="form-control _input-field" type="password" class="form-control" placeholder="Inserisci Password" id="password" name="password"></input>
					<div class="_pwd-eye">
						<i class="bi bi-eye-slash" id="togglePassword" onclick="_togglePassword()"></i>
					</div>
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