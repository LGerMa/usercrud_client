<?php 
	session_start();
	require './vendor/autoload.php'; 
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\ClientException;
	$flag_token = true;

	try{
		$client = new Client([
		    'base_uri' => 'http://localhost:3000',
		    'timeout'  => 2.0,
		]);
		$response = $client->request("GET", 'user/'.$_GET['id'], [
			'headers' => [
				'Content-Type' => 'application/json',
				'api_token' => isset($_SESSION['user']['api_token']) ? $_SESSION['user']['api_token']:''
			]
		]);

	}catch(ClientException $e){
		$response = $e->getResponse();
		$flag_token = false;
	}finally{
		$statusCode = $response->getStatusCode();

		$res = $response->getBody()->getContents();


		$res = json_decode($res, true);

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		include 'pages/header.php'
	?>
	<style>

	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<?php 
					include 'pages/menu.php';
				?>
				<div class="row">
					<div class="col s12">
						<br>
						<a href="./home.php" class="btn cyan"><i class="fas fa-caret-square-left"></i> Atrás</a>
						<div class="card-panel">
							<div class="row">
								<div class="input-field col s12">
									<i class="fas fa-user prefix"></i>
									<input type="text" id="name" value="<?php echo $res['name']; ?>">
									<label for="name">Nombre</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<i class="fas fa-envelope prefix"></i>
									<input type="text" id="email" value="<?php echo $res['email']; ?>">
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
								<a href="#!" class="col s6 btn btn-large waves-effect" id="btn_update">Actualizar</a>
								<a href="#!" class="col s6 btn btn-large waves-effect grey" id="btn_cancelar">Cancelar</a>
							</div>
						</div>
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
	$("#btn_cancelar").on("click", function(){
		location.reload();
	});

	$("#btn_update").on("click", function(){
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
			var data_to_update ="id="+<?php echo $_GET['id']; ?>+"&name="+name+"&pass="+pass+"&email="+email+"&action=EDIT_USER";
			jQuery.ajax({
				url: "./actions.php",
				type: "POST", 
				processData: false,
				data: data_to_update,
				dataType  : 'json',
				success: function(json){
					if (json.statusCode == 200) {
						message = "Usuario '"+json.data.email+"'' actualizado con éxito";
						
						Materialize.toast(message,2000);
						setTimeout(function(){
							$("#btn_cancelar").trigger('click');	
						}, 2000);
					}else{
						message = "Error al actualizar el usuario <br> "+json.statusCode+" -- "+json.error;
						Materialize.toast(message,2000);
					}

					
				}
			});
		}else{
			Materialize.toast(errors, 2000);
		}	
	});

	$("#btn_cerrar_sesion").on("click", function(){
		var data = "action=SALIR"
		jQuery.ajax({
		  url: "./actions.php",
		  type: "POST", 
		  processData: false,
		  data: data,
		  dataType  : 'json',
		  success: function(json){
		  	window.location.replace("./index.php");
		  }
		});
	});
</script>
</html>