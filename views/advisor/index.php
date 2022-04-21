<?php

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
//busco las consultas segun el metodo de l URL


$rutas = explode("/", $_GET["ruta"]);
$method = str_replace("-","",$rutas[2]);



switch ($method){

    case "preferenceadvisor":

        $respuesta = ControllerAdvisor::ctrShowAdvisor($obj);

        echo $respuesta;

        break;

    case "contract":

        $respuesta = ControllerAdvisor::ctrContract($obj);

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

