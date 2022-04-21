<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');

//$json = array(
//    "status" =>200,
//    "result" => var_dump($data),
//    "comment" =>"Error, contact administrator funcion"
//);
//
//echo json_encode($json,http_response_code($json["status"]) );
//
//return;


/*=============================
CONTROLLER
===============================*/
require_once "controller/template.controller.php";
require_once "controller/users.controller.php";
require_once "controller/advisor.controller.php";
require_once "controller/class.fileuploader.php";


/*=============================
    MODELS
===============================*/
require_once "models/users.model.php";
require_once "models/advisor.model.php";
require_once "models/rutas.php";

/*=============================
    EXTENSIONS
===============================*/

require_once "extensions/PHPMailer/PHPMailerAutoload.php";
require_once "extensions/vendor/autoload.php";

require __DIR__ . '/vendor/autoload.php';

$plantilla = new ControllerTemplate();
$plantilla-> ctrTemplate();
