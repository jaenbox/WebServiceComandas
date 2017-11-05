<?php

/**
 * Representa el la estructura de los pedidos
 * almacenadas en la base de datos
 */
require 'Database.php';

class Pedido {

    function __construct(){}

    /**
     * Retorna todas las filas del usuarios logueado de la tabla 'pedido'
     *
     * @param $id Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll($idUser) {
        /*Formato de fecha del servidor */
        $fecha = date('Y-m-d');
        $formato = 'Y-m-d';
        $fecha = \DateTime::createFromFormat($formato, $fecha);
        $fecha = date_format($fecha, 'Y-m-d');
        // Consulta sobre todos los pedidos del dia actual.
        $consulta = "SELECT p.id, p.id_mesa, p.fecha, p.pagado, p.estado, p.id_user 
        			FROM pedido p 
        			WHERE p.id_user = :id_user AND p.fecha = :fecha";
        try {
            // Preparar sentencia
            $pedido = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $pedido->execute(array('id_user' => $idUser, 'fecha' => $fecha));

            return $pedido->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getLast($idUser) {
        /*Formato de fecha del servidor */
        $fecha = date('Y-m-d');
        $formato = 'Y-m-d';
        $fecha = \DateTime::createFromFormat($formato, $fecha);
        $fecha = date_format($fecha, 'Y-m-d');
        
        $consulta = "SELECT p.id, p.id_mesa, p.fecha, p.id_user, pl.name, pl.price, c.observaciones
					FROM comanda as c
					INNER JOIN pedido as p ON p.id = c.id_pedido
					INNER JOIN plato as pl ON c.id_plato = pl.id
					WHERE p.id_user = :id_user AND p.fecha = :fecha AND c.id_pedido = 
						(SELECT max(p.id)
						FROM pedido as p)";
        try {
            // Preparar sentencia
            $pedido = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $pedido->execute(array('id_user' => $idUser, 'fecha' => $fecha));

            return $pedido->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    public static function insert($id, $id_mesa, $fecha, $pagado, $estado, $id_user) {

        $sql = "INSERT INTO pedido ( ". 
                "id,".           
                " id_mesa,".
                " fecha,".
                " pagado,".
                " estado,".
                " id_user )".
                " VALUES ( ?, ?, ?, ?, ?, ? )";

        $sentencia = Database::getInstance()->getDb()->prepare($sql);

        /*Formato de fecha del servidor */
        $fecha = date('Y-m-d');
        $formato = 'Y-m-d';
        $fecha = \DateTime::createFromFormat($formato, $fecha);
        $fecha = date_format($fecha, 'Y-m-d');

        return $sentencia->execute(array(
            $id,
            $id_mesa,
            $fecha,
            $pagado,
            $estado,
            $id_user
            ));
    }


    public static function getLastId() {
        // Consulta de la meta
        $consulta = "SELECT * FROM pedido ORDER BY id desc limit 1";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row['id'];

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    public static function insertComanda($id, $id_plato, $id_pedido, $cantidad, $observaciones) {
        
        $sql  = "INSERT INTO comanda (" .
            "id,".
            " id_plato,".
            " id_pedido,".
            " cantidad,".
            " observaciones )".
            " VALUES (?, ?, ?, ?, ?)";

        $sentencia = Database::getInstance()->getDb()->prepare($sql);

        return $sentencia->execute(array(
            $id,
            $id_plato,
            $id_pedido,
            $cantidad, 
            $observaciones
            ));
    }
}

?>