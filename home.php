<?php
	session_start();
	require './vendor/autoload.php'; 
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\ClientException;
	$flag_token = true;
//	if(!isset($_SESSION['api_token'])){
//		$flag_token = false;
//	}else{
		try{
			$client = new Client([
			    'base_uri' => 'http://localhost:3000',
			    'timeout'  => 2.0,
			]);
			$response = $client->request("GET", 'users', [
				'headers' => [
					'Content-Type' => 'application/json',
					'api_token' => isset($_SESSION['user']['api_token']) ? $_SESSION['user']['api_token']:''
				]
			]);
			

			
		}catch (ClientException $e) {

			$response = $e->getResponse();

			//$statusCode = $response->getStatusCode();

			//$res = $response->getBody()->getContents();
			$flag_token = false;

		}finally{
			$statusCode = $response->getStatusCode();

			$res = $response->getBody()->getContents();


			$res = json_decode($res, true);
		}	
	//}
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
		<?php if($flag_token){ ?>
		<div class="row">
			<div class="col-s12">
				<?php 
					include 'pages/menu.php';
				?>
				<div class="card-panel">

				<ul class="collection">
					<?php 
					  foreach ($res as $r) {
					    echo "
					      <li class='collection-item'>
					        <span class='title'>".$r['name']."</span>
					        <input type='hidden' value='".$r['id']."'></input>
					        <p>".$r['email']."</p>
					        <a href='profile.php?id=".$r['id']."' class='btn blue'><i class='fas fa-eye' name='btn_ver' target='_blank'></i> Ver</a>
					        <a href='#!' class='btn red' name='btn_delete'><i class='fas fa-trash-alt'></i> Eliminar</a>
					      </li>
					    ";
					  }
					?>
				</ul>
        </div>
			</div>
		</div>
		<?php }else{
			echo "<h2>ERROR:  ".$statusCode."</h2><br>";
			echo "<h3>".$res['error']."</h3><br>";
			echo "<div class='row'>
						
				<a href='index.php' class='col s12 btn btn-large waves-effect cyan' id='btn_login'>Iniciar sesión</a>
			</div>";

		}?>
	</div>
	
</body>
<?php 
	include 'pages/scripts.php'
?>
<script>
	$(document).ready(function(){

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

	$("a[name=btn_delete]").on("click", function(){
		var id = $(this).parent().find("input").val();
		var data_delete = "id_eliminar="+id+"&action=DELETE_USER";
		jQuery.ajax({
			url: "./actions.php",
			type: "POST", 
			processData: false,
			data: data_delete,
			dataType  : 'json',
			success: function(json){
				if (json.statusCode == 200) {
					message = "Usuario: '"+json.data.email+"' eliminado con éxito";
				}else{
					message = "Error: "+json.statusCode+" -- "+json.error;

				}

				Materialize.toast(message,2000);
				setTimeout(function(){
					window.location.replace("./home.php");
				}, 2000);
			}
		});
	});
</script>
</html>