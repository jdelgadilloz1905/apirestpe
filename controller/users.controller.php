<?php
class ControllerUsers{

    /*=============================================
    REGISTRO DE CUENTA DIRECTA
    =============================================*/

    static public function ctrUserRegister($data){

        if (isset($data["email"])) {

            $encriptarEmail = md5($data["email"]);

            //codigo de verificacion
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

            $code= strtoupper(substr(str_shuffle($permitted_chars), 0, 6));

            $encriptar = crypt($code, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

            $datos = array(
                "name" => $data["name"],
                "last" => $data["last"],
                "email" => $data["email"],
                "password"=>$encriptar,
                "photo" => "",
                "modo" => $data["modo"],
                "profile"=> $data["profile"],
                "phone"=> $data["phone"],
                "company"=> $data["company"],
                "country"=> $data["country"],
                "code"=>$code,
                "email_encriptado" => $encriptarEmail);

            //ANTES REALIZO UNA VALIDACION SI EL USUARIO EXISTE NUEVAMENTE PARA EVITAR DUPLICIDAD
            $result = self::ctrShowUsers("email",trim($data["email"])) ;

            if(isset($result["email"])){

                $json = array(
                    "status" =>404,
                    "result" => $result,
                    "comment" =>"The email already exists in the database, please enter a different one!",
                );

                echo json_encode($json,http_response_code($json["status"]));

                return;

            }else{

                $response = ModelUsers::mdlUserRegister("users", $datos);

                $datosUser = self::ctrShowUsers("id",$response["lasId"]) ;

                $datos2 = array(
                    "id_user" => $datosUser["id"],
                    "step_one" => $data["step_one"],
                    "step_two" => $data["step_two"],
                    "step_three" => $data["step_three"],
                    "step_four" => $data["step_four"],
                    "step_five" => $data["step_five"],
                    "step_six" => $data["step_six"],
                    "step_seven" => $data["step_seven"],
                    "step_eight" => $data["step_eight"],
                    "step_nine" => $data["step_nine"],
                    "step_ten" => $data["step_ten"],
                    "step_eleven" => $data["step_eleven"],
                    "step_twelve" => $data["step_twelve"],
                    "step_thirteen" => $data["step_thirteen"],
                    "step_fourteen" => $data["step_fourteen"],
                    "step_fifteen" => $data["step_fifteen"],
                    "step_sixteen" => $data["step_sixteen"],
                    "step_sixteen2" => isset($data["step_sixteen2"]) ? $data["step_sixteen2"] : "",
                    "step_seventen" => $data["step_seventen"],
                    "step_eighteen" => $data["step_eighteen"],
                    "step_nineteen" => $data["step_nineteen"]
                );

                $response2 = ModelUsers::mdlUserRegister("answers", $datos2);

                if (isset($response["lasId"])) {

                    /*=============================================
                    VERIFICACIÓN CORREO ELECTRÓNICO
                    =============================================*/

                    date_default_timezone_set("America/Bogota");


                    $image_email= Ruta::ctrRutaLogoEmail();

                    $codeVerification = $datosUser["code"];
                    $name = $datosUser["name"]. " ". $datosUser["last"];

                    $mail = new PHPMailer;

                    $mail->CharSet = 'UTF-8';

                    $mail->isMail();

                    $mail->setFrom('hi@pe.com', 'PE');

                    $mail->addReplyTo('hi@pe.com', 'PE');

                    $mail->Subject = "Verification code";

                    $mail->addAddress($datosUser["email"]);

                    $mail->msgHTML('
                                <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

                                    <div style="position:relative; margin:auto; width:600px; background:white; padding:20px">

                                        <center>

                                            <img style="padding:20px; width:15%" src="'.$image_email.'">

                                            <h3 style="font-weight:100; color:#999">VERIFY YOUR EMAIL ADDRESSO</h3>

                                            <hr style="border:1px solid #ccc; width:80%">
                                            
                                            <h4 style="font-weight:100; color:#999; padding:0 20px">Hi : '.$name.'</h4>

                                            <h4 style="font-weight:100; color:#999; padding:0 20px">Your verification code is: '.$codeVerification.'</h4>

                                            <br>

                                            <hr style="border:1px solid #ccc; width:80%">

                                            <h5 style="font-weight:100; color:#999">If you have not signed up for this account, you can ignore this email and the account will be deleted.</h5>

                                        </center>

                                    </div>
                                </div>'
                    );

                    $mail->Send();

//                    if (!$envio) {
//
//                        $response = array(
//                            "statusCode" => 400,
//                            "error" => false,
//                            "mensaje" =>"There was a problem sending email verification to " . $data["email"] . $mail->ErrorInfo . "!"
//                        );
//
//                    }

                }

                echo json_encode($response,http_response_code($response["status"]));

                return;

            }

        }


    }

    /*=============================================
	ACTUALIZAR PASSWORD
	=============================================*/

    static public function ctrActualizarPassword($data){

        if(isset($data["id"])) {

            $passwordNuevo = crypt($data["newPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $fecha_actual = date("Y-m-d");

            $datos = array(
                "id"=>$data["id"],
                "password_expiry_date"=>date("Y-m-d",strtotime($fecha_actual."+ 30 days")),
                "password"=>$passwordNuevo
            );
            $resp = ModelUsers::mdlActualizarPassword("users", $datos);

            if($resp == "ok"){

                $result = array(
                    "statusCode" => 200,
                    "error" => false,
                    "mensaje" =>"Excelente trabajo, Tu contraseña ha sido cambiada exitosamente.",
                );

            }else{

               $result = array(
                   "statusCode" => 400,
                   "error" => true,
                   "mensaje" =>"¡Error al cambiar su contraseña, contacte con el administrador!",
               );


            }
            //echo json_encode($datos,200);
            echo json_encode($result,http_response_code($result["statusCode"]));

        }

    }
    /*=============================================
	ACTUALIZAR DATOS DE USUARIO
	=============================================*/
    static public function ctrUpdateUser($data){

        if(isset($data["id"])) {

            $encriptarEmail = md5($data["email"]);

            $datos = array(
                "id"=>$data["id"],
                "name"=>$data["name"],
                "email"=>$data["email"],
                "last"=>$data["last"],
                "company"=>$data["company"],
                "country"=>$data["country"],
                "bio_text"=>$data["bio_text"],
                "phone"=>$data["phone"],
                "email_encriptado"=>$encriptarEmail
            );

            $resp = ModelUsers::mdlUpdateUserData("users", $datos);

            if($resp == "ok"){

                $result = array(
                    "statusCode" => 200,
                    "error" => false,
                    "mensaje" =>"Cambios actualizados correctamente",
                );

            }else{

                $result = array(
                    "statusCode" => 400,
                    "error" => true,
                    "mensaje" =>"¡Error actualizando, ". $resp,
                );


            }
            //echo json_encode($datos,200);
            echo json_encode($result,http_response_code($result["statusCode"]));
        }
    }

    /*=============================================
    VERIFICACION DE EMAIL DE CUENTA DIRECTA
    =============================================*/

    static public function ctrVerifyUser($data){

        $respuesta = self::ctrShowUsers("code", $data["code"]);

        if(isset($respuesta["email"])){

            $respuesta2 = ModelUsers::mdlUpdateUser("users", "id", $respuesta["id"], "verified", 1);

            if($respuesta2 == "ok"){
                //se envia un email

                $json = array(
                    "status" =>200,
                    "result" => $respuesta,
                    "comment" =>"account activated",
                );

                echo json_encode($json,http_response_code($json["status"]));

                return;

            }

        }else{
            $json = array(
                "status" =>404,
                "result" => "",
                "comment" =>"Error verifying user, contact administrator!",
            );

            echo json_encode($json,http_response_code($json["status"]));

            return;

        }
    }

    /*=============================================
    MOSTRAR USERS
    =============================================*/
    static public function ctrShowUsers($item,$valor){

        $tabla = "users";

        $respuesta = ModelUsers::mdlShowUsers($tabla,$item,$valor);

        return $respuesta;

    }

    /*=============================================
    INGRESAR USUARIO
    =============================================*/
    static public function ctrLoginUser($data){

        if(isset($data["email"])){

            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $data["email"]) &&
                preg_match('/^[a-zA-Z0-9.,]+$/', $data["password"])){

                $encrypt = crypt($data["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $answer = ModelUsers::mdlShowUsers("users","email",$data["email"]);

                if(isset($answer["email"])){
                    if($answer["email"] == $data["email"] && $answer["password"] == $encrypt){

                        if($answer["verified"] == 1){
                            if($answer["state"] == 1){

                                /*=============================================
                                REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
                                =============================================*/

                                self::ctrUpdateLastLogin("users",$answer["id"]);

                                $json = array(
                                    "status" =>200,
                                    "result" => $answer,
                                    "comment" =>"You have successfully logged in.",
                                );

                                echo json_encode($json,http_response_code($json["status"]));
                                return;

                            }else{

                                $json = array(
                                    "status" =>404,
                                    "result" => "",
                                    "comment" =>"The account is deactivated, contact the administrator",
                                );

                                echo json_encode($json,http_response_code($json["status"]));
                                return;

                            }
                        }else{
                            $json = array(
                                "status" =>404,
                                "result" => "",
                                "comment" =>"The account has not been verified",
                            );

                            echo json_encode($json,http_response_code($json["status"]));
                            return;
                        }
                    }else{
                        $json = array(
                            "status" =>404,
                            "result" => "",
                            "comment" =>"invalid email or password",
                        );

                        echo json_encode($json,http_response_code($json["status"]));
                        return;

                    }
                }else{
                    $json = array(
                        "status" =>404,
                        "result" => "",
                        "comment" =>"invalid email",
                    );

                    echo json_encode($json,http_response_code($json["status"]));
                    return;
                }



            }

        }
    }

    /*=============================================
    REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
=============================================*/
    static public function ctrUpdateLastLogin($tabla,$id){

        date_default_timezone_set('America/Bogota');

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        $fechaActual = $fecha.' '.$hora;

        $item1 = "last_login";
        $valor1 = $fechaActual;

        $item2 = "id";
        $valor2 = $id;

        ModelUsers::mdlUpdateUser($tabla, $item1, $valor1, $item2, $valor2);
    }

    /*=============================================
     RECUPERAR LA CLAVE
     =============================================*/

    static public function ctrRestorePassword($data){

        if(isset($data["email"])){

            if(preg_match('/^[^0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,4}$/', $data["email"])){

                /*=============================================
                GENERAR CONTRASEÑA ALEATORIA
                =============================================*/

                function generarPassword($longitud){

                    $key = "";
                    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";

                    $max = strlen($pattern)-1;

                    for($i = 0; $i < $longitud; $i++){

                        $key .= $pattern[mt_rand(0,$max)];

                    }

                    return $key;

                }

                $nuevaPassword = generarPassword(11);

                $encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $item1 = "email";
                $valor1 = $data["email"];

                $respuesta1 = ModelUsers::mdlShowUsers("users",$item1,$valor1);

                if($respuesta1){

                    $valor = $respuesta1["id"];
                    $item2 = "password";
                    $valor2 = $encriptar;

                    $respuesta2 = ModelUsers::mdlUpdateUser("users", "id",$valor, $item2, $valor2);

                    if($respuesta2  == "ok"){

                        /*=============================================
                        CAMBIO DE CONTRASEÑA
                        =============================================*/

                        $url = Ruta::ctrRutaEnvioEmailAuth();

                        $image_email= Ruta::ctrRutaLogoEmail();

                        date_default_timezone_set("America/Bogota");

                        $mail = new PHPMailer;

                        $mail->CharSet = 'UTF-8';

                        $mail->isMail();

                        $mail->setFrom('hi@pe.com', 'PE');

                        $mail->addReplyTo('hi@pe.com', 'PE');

                        $mail->Subject = "Did you forget your password?";

                        $mail->addAddress($data["email"]);

                        $mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

								<center>

									<img style="padding:20px; width:10%" src="">

								</center>

								<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">

									<center>

									<img style="padding:20px; width:15%" src="'.$image_email.'">

									<h3 style="font-weight:100; color:#999">REQUEST FOR A NEW PASSWORD</h3>

									<hr style="border:1px solid #ccc; width:80%">

									<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Your new password: </strong>'.$nuevaPassword.'</h4>

									<a href="'.$url.'" target="_blank" style="text-decoration:none">

									<div style="line-height:60px; background:#1890ff; width:60%; color:white">Enter the site again</div>

									</a>

									<br>

									<hr style="border:1px solid #ccc; width:80%">

									<h5 style="font-weight:100; color:#999">If you have not signed up for this account, you can ignore this email and the account will be deleted.</h5>

									</center>

								</div>

							</div>');

                        $envio = $mail->Send();


                        if(!$envio){

                            $json = array(
                                "status" =>404,
                                "result" => $nuevaPassword,
                                "comment" =>"There was a problem sending password change to ".$data["email"]."!", //$mail->ErrorInfo.
                            );


                        }else{

                            $json = array(
                                "status" =>200,
                                "result" => $nuevaPassword,
                                "comment" =>"Check your email to confirm the account.",
                            );


                        }

                        echo json_encode($json,http_response_code($json["status"]));
                        return;

                    }

                }else{

                    $json = array(
                        "status" =>404,
                        "result" => "",
                        "comment" =>"Email does not exist in the system!",
                    );

                    echo json_encode($json,http_response_code($json["status"]));
                    return;
                }

            }else{

                $json = array(
                    "status" =>404,
                    "result" => "",
                    "comment" =>"Error sending email, it's misspelled!",
                );

                echo json_encode($json,http_response_code($json["status"]));
                return;


            }

        }


    }

    /*===============================================
    SUBIR IMAGEN DE PERFIL
      ===============================================*/
    static public function ctrCargaImagen(){

        $FileUploader = new FileUploader('imagen',array(

            'limit' => 5,
            'maxSize' => null,
            'fileMaxSize' => 5,
            'extensions' => null,
            'required' => false,
            'uploadDir' => "views/img/users/",
            'title' => 'auto',
            'replace' => false,
            'listInput' => true,
            'files' => null,
            'editor' => true
        ));

        // desvincular los archivos
        // !importante solo para archivos precargados
        // you will need to give the array with appendend files in 'files' option of the fileUploader
        //deberá proporcionar la matriz con los archivos adjuntos en la opción 'archivos' del archivo Cargador

        /*foreach($FileUploader->getRemovedFiles('file') as $key=>$value) {
            unlink('views/img/anuncios/' . $value['name']);
        }*/

        // llama para subir los archivos
        $data = $FileUploader->upload();

        // SI CARGO LOS ARCHIVOS, MENSAJE DE EXITO
        if($data['isSuccess'] && count($data['files']) > 0) {
            // obtener archivos cargados
            $uploadedFiles = $data['files'];
        }

        // obtener la lista de archivos
        $fileList = $FileUploader->getFileList();

        //debe haber un return para mandar el json donde lo pidan

        $json = array(
            "status" =>200,
            "result" => $fileList,
            "cantidad" =>count($_FILES['imagen']['tmp_name']),
            "url" => Ruta::ctrRutaImagen(),
            "comment" =>"You have successfully logged in.",
        );

        echo json_encode($json,http_response_code($json["status"]));
        return;
    }

    static public function ctrUpdateImage($data){

        $result = ModelUsers::mdlUpdateUser("users","id",$data["id"],"photo",$data["image"]);

        if($result == "ok"){

            $json = array(
                "status" =>200,
                "result" => self::ctrShowUsers("id",$data["id"]),
                "comment" =>"The process was successful"
            );

        }else{
            $json = array(
                "status" =>404,
                "result" => "",
                "comment" =>"Error updating photo "
            );

        }
        echo json_encode($json,http_response_code($json["status"]) );
        return;
    }

    /*===============================================
    REGISTRAR FORMULARIO
    =================================================*/

    static public function ctrRegisterAnswersUser($data){

        $datos = array(
            "id_user" => $data["id_user"],
            "step_one" => $data["step_one"],
            "step_two" => $data["step_two"],
            "step_three" => $data["step_three"],
            "step_four" => $data["step_four"],
            "step_five" => $data["step_five"],
            "step_six" => $data["step_six"],
            "step_seven" => $data["step_seven"],
            "step_eight" => $data["step_eight"],
            "step_nine" => $data["step_nine"],
            "step_ten" => $data["step_ten"],
            "step_eleven" => $data["step_eleven"],
            "step_twelve" => $data["step_twelve"],
            "step_thirteen" => $data["step_thirteen"],
            "step_fourteen" => $data["step_fourteen"],
            "step_fifteen" => $data["step_fifteen"],
            "step_sixteen" => $data["step_sixteen"],
            "step_sixteen2" => isset($data["step_sixteen2"]) ? $data["step_sixteen2"] : "",
            "step_seventen" => $data["step_seventen"],
            "step_eighteen" => $data["step_eighteen"],
            "step_nineteen" => $data["step_nineteen"]
        );

        $response = ModelUsers::mdlUserRegister("answers", $datos);

        if (isset($response["lasId"])) {

            self::fncResponse($response);
        }
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