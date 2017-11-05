<?php

	require 'Plato.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$body = json_decode(file_get_contents("php://input"), true);
		
		$retornoPlato = Plato::insert(
			$body['id'],
			$body['name'],
			$body['price'],
			$body['path'],
			$body['description'],
			$body['category']
		);

		if($retornoPlato) {
			echo json_encode(
	            		array(
	               			'estado' => '1',
	                		'mensaje' => 'Plato almacenado')
	        			);
		} else {
			// Código de falla
	        echo json_encode(
	        	array(
	        		'estado' => '2',
	           		'mensaje' => 'Creación plato fallida')
	        	);
		}
	}
	
?>