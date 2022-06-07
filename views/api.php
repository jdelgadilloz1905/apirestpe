<?php

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');    // cache for 1 day
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == "GET" ||  $_SERVER['REQUEST_METHOD'] == "PUT" || $_SERVER['REQUEST_METHOD'] == "DELETE") {

    if(isset($_GET["ruta"])){

        $rutas = explode("/", $_GET["ruta"]);

        if(isset($rutas[1])){

            include "".$rutas[1]."/index.php";

        }else{
            $json = array(
                "status" =>404,
                "result" => "Access denied",
                "comment" =>"Error, contact administrator"
            );

            echo json_encode($json,http_response_code($json["status"]) );

            return;
        }

    }


}



