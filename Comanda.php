<?php
	require 'Pedido.php';

	$body = json_decode(file_get_contents("http://input"), true);

	$retorno = Pedido::insert(
		$body['id_mesa'],
		$body['fecha'],
		$body['pagado'],
		$body['estado'],
		$body['id_user']
		);

	if($retorno) {
		$datos["pedido"] = $retorno;
		print json_encode($datos);
	} else {
		// error
	}
?>