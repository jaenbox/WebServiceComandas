<?php
/**
 * Obtiene todas los pedidos del usuario logueado
 */

require 'Pedido.php';

$idUser = $_REQUEST['user'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $pedidos = Pedido::getAll($idUser);

    if ($pedidos) {

        $datos["pedidos"] = $pedidos;

        print json_encode($datos);
        
    } else {
        echo "false";
    }
}
?>