<?php

require_once "conexion.php";

class ModelAdvisor{

    /*=============================================
        MOSTRAR ADVISOR
        =============================================*/

    static public function mdlShowAdvisor($tabla, $data){

        $profile = 1;

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE profile = :profile LIMIT 3");

        $stmt -> bindParam(":profile", $profile, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;

    }

    static public function mdlContract($tabla, $data){

        $stmt = Conexion::conectar()->prepare("SELECT c.*, 'OPEN' as notes, CONCAT(u.name, ' ',u.last) name1  
                                                          FROM $tabla c  
                                                          LEFT JOIN users u 
                                                            ON c.id_client = u.id 
                                                            WHERE status_client = :status_client LIMIT 5");

        $stmt -> bindParam(":status_client", $data['status_client'], PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }


}