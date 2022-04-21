<?php

use Twilio\Rest\Client;

class Ruta{

    /*=============================================
    RUTA PARA ACCEDER AL TEMPLATE SIN HTTPS
    =============================================*/
    static public function ctrRutaLogoEmail(){


        return "http://estudio57.net/apirestpe/views/img/logo_email.jpg";

    }

    static public function ctrVisionGoogleCloudAPI(){

        return "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyCoiwg_wwglI8bOEiXlePkCRq3GL7S2uTk";
    }

    static public function ctrRutaEnvioEmailAuth(){


        return "https://peweb2022.herokuapp.com/";


    }

    static public function ctrRutaImagen(){


        return "https://estudio57.net/apilicenciasweb/";


    }

    static public function ctrTokenTwilio(){

        $sid = 'ACe11913c89ad3d7a403523181fde69262';
        $token = 'ce62d80d2e10f681216478bcc8195155';
        $client = new Client($sid, $token);

        return $client;
    }
}