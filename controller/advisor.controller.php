<?php
class ControllerAdvisor{

    /*=============================================
    ALL ADVISOR
    =============================================*/

    static public function ctrShowAdvisor($data){

        $tabla = "users";

        $respuesta = ModelAdvisor::mdlShowAdvisor($tabla,$data);

        if(count($respuesta)>0){
            $json = array(
                "status" =>200,
                "result" => $respuesta,
                "comment" =>"",
            );
        }else{
            $json = array(
                "status" =>404,
                "result" => "",
                "comment" =>"Not found",
            );
        }
        echo json_encode($json,http_response_code($json["status"]));

        return;

    }

    static public function ctrContract($data){

        $tabla = "contracts";

        $respuesta = ModelAdvisor::mdlContract($tabla, $data);

        if(count($respuesta)>0){
            $json = array(
                "status" =>200,
                "result" => $respuesta,
                "comment" =>"",
            );
        }else{
            $json = array(
                "status" =>404,
                "result" => "",
                "comment" =>"Not found",
            );
        }
        echo json_encode($json,http_response_code($json["status"]));

        return;


    }

    /*==============================================
    Respuestas del controlador
    ================================================*/
    static public function fncResponse($response){

        if(!empty($response)){

            echo json_encode($response,http_response_code($response["status"]) );

            return;
        }else{

            $json = array(
                "status" =>404,
                "result" => "Not found",
                "methos" =>"post",
                "comment" =>"Error, contact administrator"
            );

            echo json_encode($json,http_response_code($json["status"]) );

            return;
        }


    }


}