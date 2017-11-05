<?php

	require 'Pedido.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$body = json_decode(file_get_contents("php://input"), true);
		
		$retornoPedido = Pedido::insert(
			$body['id'],
			$body['id_mesa'],
			$body['fecha'],
			$body['pagado'],
			$body['estado'],
			$body['id_user']
			);
		
		//$retornoPedido = true;
		if($retornoPedido) {	
        	// último id almacenado.
			$retornoIdLastPedido = Pedido::getLastId();
			
			if($retornoIdLastPedido >= 0) {
				// recogemos el número de platos pasados en el json.
				$num_platos = $body['num_platos'];
				// Creamos el array para recoger todos los id de los platos seleccionados.
				$platos = array($num_platos);
				
				for($i=0; $i < $num_platos; $i++) {
					$platos[$i] = $body['plato'.$i];
				}

				$retornoComanda = false;

				for($i=0; $i < $num_platos; $i++) {
					
					$retornoComanda = Pedido::insertComanda(
					$body['id'],
					$body['plato'.$i],
					$retornoIdLastPedido,
					$body['cantidad'],
					$body['observaciones']
					);
					
					// Si falla algun insert se para el bucle.
					if($retornoComanda == false) {
						break;
					}
					
				}
				
				if($retornoComanda) {
					echo json_encode(
	            		array(
	               			'estado' => '1',
	                		'mensaje' => 'Pedido tramitado')
	        			);						
				} else {
					// Código de falla
	        		echo json_encode(
	            		array(
	               			'estado' => '2',
	                		'mensaje' => 'Creación comanda fallida')
	        		);	
				}
				
			} else {
				echo json_encode(
            		array(
               			'estado' => '2',
                		'mensaje' => 'Retorno último pedido fallida')
        		);
			}				
		} else {
			// Código de falla
        	echo json_encode(
            	array(
               		'estado' => '2',
                	'mensaje' => 'Retorno Pedido fallida')
        	);
		}	
	}
	
?>