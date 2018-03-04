<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		include 'pages/header.php'
	?>
	<style>
		#login-page{
			display: table;
			margin: auto;
		}
	</style>
</head>
<body>
	<br>
	<div id="login-page" class="row">
		<div class="col s12">
			<div class="card-panel">
				<div class="loginForm">
					<div class="row">
						<div class="input-field col s12 center">
							<h4 class="center loginForm_title">
								Inicio de sesión
							</h4>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-envelope prefix"></i>
							<input type="email" id="email">
							<label for="email">Correo</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-key prefix"></i>
							<input type="password" class="validate" id="password">
							<label for="password">Contraseña</label>
						</div>
					</div>
					<div class="row">
						<a href="#!" class="col s12 btn btn-large waves-effect indigo" id="btn_ingresar">Ingresar</a>
						<a href="registrer.php" class="col s12 btn btn-large waves-effect cyan" id="btn_crear_cuenta">Crear cuenta</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php 
	include 'pages/scripts.php'
?>
<script>
	$("#btn_ingresar").on('click', function(){
		var email = $("#email").val();
		var pass = $("#password").val();
		var errors = "";
		var message = "";

		if (email == "")
			errors += "Correo es un campo requerido<br>";
		if (pass == "")
			errors+= "Contraseña es campo requerido<br>";
		if (errors == ""){
			var data_to_save = "email="+email+"&pass="+pass+"&action=LOGIN";
			jQuery.ajax({
				url: "./actions.php",
				type: "POST", 
				processData: false,
				data: data_to_save,
				dataType  : 'json',
				success: function(json){
					if (json.statusCode == 200) {
						message = "Redirecionando a home...";
						Materialize.toast(message,2000);
						setTimeout(function(){
							window.location.replace("./home.php");
						}, 2000);
					}else{
						message = "Error: "+json.statusCode+"--"+json.error;
						Materialize.toast(message,2000);

					}

				}
			});
		}else{
			Materialize.toast(errors, 2000);
		}	
	});
</script>
</html>