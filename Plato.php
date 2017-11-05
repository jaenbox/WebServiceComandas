<?php

/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
require 'Database.php';

class Plato
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'plato'
     *
     * @param $idMeta Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT p.id, p.name, p.price, p.description, p.category FROM plato p";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    /*
        insert
    */
    public static function insert($id, $name, $price, $path, $description, $category) {

        $sql = "INSERT INTO plato ( ". 
                "id,".           
                " name,".
                " price,".
                " path,".
                " description,".
                " category )".
                " VALUES ( ?, ?, ?, ?, ?, ? )";

        $sentencia = Database::getInstance()->getDb()->prepare($sql);

        return $sentencia->execute(array(
            $id,
            $name,
            $price,
            $path,
            $description,
            $category
            ));
    }

    public static function getLast() {

        $sql = "SELECT MAX(id) FROM plato";

        // Preparar sentencia
        $comando = Database::getInstance()->getDb()->prepare($sql);
        // Ejecutar sentencia preparada
        $comando->execute();

        return $comando->fetchAll(PDO::FETCH_ASSOC);
        
    }
}

?>