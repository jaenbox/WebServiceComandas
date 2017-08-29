<?php
/**
 * Obtiene todas los platos de la base de datos
 */

require 'Plato.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $platos = Plato::getAll();

    if ($platos) {

        $datos["platos"] = $platos;

        print json_encode($datos);
    } else {
       // 
    }
}
?>