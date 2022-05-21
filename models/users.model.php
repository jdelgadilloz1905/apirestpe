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

    /*=============================================
	ACTUALIZAR DATOS USER
	=============================================*/

    static public function mdlUpdateUserData($tabla, $datos){
        try {

            $stmt = Conexion::conectar()->prepare("UPDATE users SET 
                                                                name = :name, 
                                                                email = :email, 
                                                                last = :last, 
                                                                company =:company, 
                                                                country = :country, 
                                                                bio_text = :bio_text, 
                                                                phone = :phone, 
                                                                email_encriptado = :email_encriptado
                                                                WHERE id = :id");

            $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
            $stmt -> bindParam(":name", $datos["name"], PDO::PARAM_STR);
            $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
            $stmt -> bindParam(":last", $datos["last"], PDO::PARAM_STR);
            $stmt -> bindParam(":company", $datos["company"], PDO::PARAM_STR);
            $stmt -> bindParam(":country", $datos["country"], PDO::PARAM_STR);
            $stmt -> bindParam(":bio_text", $datos["bio_text"], PDO::PARAM_STR);
            $stmt -> bindParam(":phone", $datos["phone"], PDO::PARAM_STR);
            $stmt -> bindParam(":email_encriptado", $datos["email_encriptado"], PDO::PARAM_STR);



            if($stmt -> execute()){

                return "ok";

            }else{

                return "error";

            }


        }catch (PDOException $pe) {

            return "Error occurred:" . $pe->getMessage();

        }

        $stmt -> close();

        $stmt = null;

    }


    /*============================================
       ACTUALIZAR PASSWORD
    ==============================================*/

    static public function mdlActualizarPassword($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET password = :password, password_expiry_date = :password_expiry_date WHERE id = :id");

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":password_expiry_date", $datos["password_expiry_date"], PDO::PARAM_STR);

        if($stmt -> execute()){

            return "ok";

        }else{

            return "error";

        }

        $stmt-> close();

        $stmt = null;

    }


}