<?php
	require './vendor/autoload.php'; 
	use GuzzleHttp\Client;
	use GuzzleHttp\Psr7;
	use GuzzleHttp\Exception\ClientException;

	try{
		$headers = ['Content-Type' => 'application/json'];

		$client = new Client([
		    // Base URI is used with relative requests
		    'base_uri' => 'http://localhost:3000',
			//'base_uri' => 'https://jsonplaceholder.typicode.com',
		    // You can set any number of default request options.
		    'timeout'  => 2.0,
		]);

		$response = $client->request('GET', 'users', [
			'headers' => [
				'Content-Type' => 'application/json'
			]
		]);

		$statusCode = $response->getStatusCode();

		$res = $response->getBody()->getContents();


		$res = json_decode($res, true); 


	}catch(ClientException $e){
		//echo Psr7\str($e->getRequest());
		//echo Psr7\str($e->getResponse());

		$response = $e->getResponse();

		$statusCode = $response->getStatusCode();

		$res = $response->getBody()->getContents();


		$res = json_decode($res, true);

	}
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>prueba</title>
</head>
<body>
	<?php
		if ($statusCode == '200'){
			echo "ok";
		?>
			<div>
				<table>
					<thead>
						<tr>
							<th>name</th>
							<th>Email</th>
							<th>accion</th>
						</tr>

					</thead>
					<tbody>
						<?php 
							/*foreach ($res as $r) {
								echo "<tr>
									<td> ".$r['name']."</td>
									<td> ".$r['email']."</td>
									<td>accion</td>
								</tr>";
							}*/
							//echo $res['name'];
							echo count($res);
							var_dump($res);
						?>
					</tbody>
				</table>

			</div>
		<?php
		} else {
			echo $res['error'];
		}
	
	?>
</body>
</html>