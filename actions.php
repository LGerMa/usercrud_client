<?php 
	require './vendor/autoload.php'; 
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\ClientException;
	$action = $_POST['action'];
	$retorno = array();
	session_start();
	try {
		$client = new Client([
		    'base_uri' => 'http://localhost:3000',
		    'timeout'  => 2.0,
		]);
		switch ($action) {
			case 'LOGIN':
				$response = $client->request('POST','login',[
					'headers' => [
						'Content-Type' => 'application/json'
					],
					'json' => [
						'password' => $_POST['pass'],
						'email' => $_POST['email']
					]
				]);
				$statusCode = $response->getStatusCode();

				$res = $response->getBody()->getContents();


				$res = json_decode($res, true);

				$retorno = array(
					"statusCode" => $statusCode,
					"data" => $res
				);
				
				$_SESSION['user'] = $res;
				break;
			case 'CREATE_USER':
				
				$response = $client->request('POST','user',[
					'headers' => [
						'Content-Type' => 'application/json'
					],
					'json' => [
						'name' => $_POST['name'],
						'password' => $_POST['pass'],
						'email' => $_POST['email']
					]
				]);

				$statusCode = $response->getStatusCode();

				$res = $response->getBody()->getContents();


				$res = json_decode($res, true);

				$retorno = array(
					"statusCode" => $statusCode,
					"data" => $res
				);
				break;
			
			
			case 'EDIT_USER':
				$id = $_POST['id'];
				$response = $client->request('PUT','user/'.$id,[
					'headers' => [
						'Content-Type' => 'application/json',
						'api_token' => isset($_SESSION['user']['api_token']) ? $_SESSION['user']['api_token']:''
					],
					'json' => [
						'name' => $_POST['name'],
						'password' => $_POST['pass'],
						'email' => $_POST['email']
					]
				]);

				$statusCode = $response->getStatusCode();

				$res = $response->getBody()->getContents();


				$res = json_decode($res, true);

				$retorno = array(
					"statusCode" => $statusCode,
					"data" => $res
				);

				$_SESSION['user'] = $res;
				break;

			case 'DELETE_USER':
				$id_eliminar = $_POST['id_eliminar'];
				$response = $client->request('DELETE','user/'.$id_eliminar,[
					'headers' => [
						'Content-Type' => 'application/json',
						'api_token' => isset($_SESSION['user']['api_token']) ? $_SESSION['user']['api_token']:''
					]
				]);
				$statusCode = $response->getStatusCode();

				$res = $response->getBody()->getContents();


				$res = json_decode($res, true);

				$retorno = array(
					"statusCode" => $statusCode,
					"data" => $res
				);
				break;
			case 'SALIR':

				session_unset();
    			session_destroy();
    			$retorno = true;
				break;
			default:
				# code...
				break;
		}
		
	} catch (ClientException $e) {

		$response = $e->getResponse();

		$statusCode = $response->getStatusCode();

		$res = $response->getBody()->getContents();


		$res = json_decode($res, true);

		$retorno = array(
			"statusCode" => $statusCode,
			"error" => $res['error']
		);
		
	}finally{
		echo json_encode($retorno);
	}	


?>