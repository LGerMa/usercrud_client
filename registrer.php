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
								Registrar nuevo usuario
							</h4>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-user prefix"></i>
							<input type="text" id="name">
							<label for="name">Nombre</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-envelope prefix"></i>
							<input type="text" id="email">
							<label for="email">Correo</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-key prefix"></i>
							<input type="password" id="password">
							<label for="password">Contraseña</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="fas fa-key prefix"></i>
							<input type="password" id="confirmar_password">
							<label for="password">Confirmar contraseña</label>
						</div>
					</div>
					<div class="row">
						<a href="#!" class="col s6 btn btn-large waves-effect" id="btn_registrer">Registrar</a>
						<a href="#!" class="col s6 btn btn-large waves-effect grey" id="btn_cancelar">Cancelar</a>
					</div>
					<div class="row">
						
						<a href="index.php" class="col s12 btn btn-large waves-effect cyan" id="btn_login">Iniciar sesión</a>
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

	$(document).ready(function(){
		$("#btn_cancelar").trigger('click');
	});
	$("#btn_registrer").on('click', function(){
		//Materialize.toast('click new user', 2000);
		var name = $("#name").val();
		var pass = $("#password").val();
		var confirm_pass = $("#confirmar_password").val();
		var email = $("#email").val();
		var message = "";
		var errors = "";

		if (name == "")
			errors+= "Nombre es campo requerido<br>";
		if (email == "")
			errors += "Correo es un campo requerido<br>";
		if (pass == "")
			errors+= "Contraseña es campo requerido<br>";
		else{
			if (confirm_pass == "")
				errors+= "Confirmar contraseña es un campo requerido<br>";
			else{
				if (pass != confirm_pass)
					errors+= "Contraseñas no coinciden<br>";
			}
		}		

		if (errors == ""){
			var data_to_save = "name="+name+"&pass="+pass+"&email="+email+"&action=CREATE_USER";
			jQuery.ajax({
				url: "./actions.php",
				type: "POST", 
				processData: false,
				data: data_to_save,
				dataType  : 'json',
				success: function(json){
					if (json.statusCode == 201) {
						message = "Usuario '"+json.data.email+"'' creado con éxito";
						$("#btn_cancelar").trigger('click');
					}else{
						message = "Error al crear el usuario --- "+json.statusCode+" --- "+json.error;
					}

					Materialize.toast(message,2000);
				}
			});
		}else{
			Materialize.toast(errors, 2000);
		}	
	});

	$("#btn_cancelar").on('click', function(){
		$("#name").val("");
		$("#email").val("");
		$("#password").val("");
		$("#confirmar_password").val("");

		$("#name").trigger("focusout");
		$("#email").trigger("focusout");
		$("#password").trigger("focusout");
		$("#confirmar_password").trigger("focusout");
	});
</script>
</html>