<?php

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
//busco las consultas segun el metodo de l URL


$rutas = explode("/", $_GET["ruta"]);
$method = str_replace("-","",$rutas[2]);



switch ($method){

    case "registeruser":

        $respuesta = ControllerUsers::ctrUserRegister($obj);

        echo $respuesta;

        break;

    case "verifycode":

        $respuesta = ControllerUsers::ctrVerifyUser($obj);

        echo $respuesta;

        break;

    case "login":

        $respuesta = ControllerUsers::ctrLoginUser($obj);

        echo $respuesta;

        break;

    case "restorepassword":

        $respuesta = ControllerUsers::ctrRestorePassword($obj);

        echo $respuesta;

        break;

    case "updateimage":

        $respuesta = ControllerUsers::ctrUpdateImage($obj);

        echo $respuesta;

        break;

    case "registeranswers":

        $respuesta = ControllerUsers::ctrRegisterAnswersUser($obj);

        echo $respuesta;

        break;


    default:
        echo json_encode(
            array(
                "error" => true,
                "statusCode"=>"404",
                "metodo" =>$method,
                "valores"=>$obj
            ));
}

