<?php

require_once "conexion.php";

class ModelUsers{

    /*=============================================
        MOSTRAR USUARIOS
        =============================================*/

    static public function mdlShowUsers($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");

            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt -> execute();

            return $stmt -> fetch(PDO::FETCH_ASSOC);

        }else{

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id");

            $stmt -> execute();

            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        }


        $stmt -> close();

        $stmt = null;

    }


    /*=============================================
	REGISTRAR USUARIOS
	=============================================*/

    static public function mdlUserRegister($table, $data)
    {

        $columns = "";
        $params="";
        foreach ($data as $key => $value){

            $columns .=$key.",";
            $params .=":".$key.",";
        }
        $columns = substr($columns, 0, -1);
        $params = substr($params, 0, -1);

        $link = Conexion::conectar();
        $sql = "INSERT INTO $table ($columns) VALUES ($params )";

        $stmt = $link->prepare($sql);

        foreach ($data as $key => $value){

            $stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
        }

        if($stmt->execute()){

            $response = array(
                "status"=>200,
                "lasId"=>$link->lastInsertId(),
                "comment" => "The process was successful"

            );

            return $response;
        }else{

            return $link->errorInfo();
        }
    }

    /*=============================================
	ACTUALIZAR USER
	=============================================*/

    static public function mdlUpdateUser($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");

        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);


        if($stmt -> execute()){

            return "ok";

        }else{

            return "error";

        }

        $stmt -> close();

        $stmt = null;

    }


}