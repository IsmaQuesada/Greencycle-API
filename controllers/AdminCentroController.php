<?php
//Cargar todos los paquetes
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;
class AdminCentro 
{
    private $secret_key = 'e0d17975bc9bd57eee132eecb6da6f11048e8a88506cc3bffc7249078cf2a77a';

    public function index()
    {
        $usuario = new UsuarioModel();

        $response = $usuario->AdminCentroAcopio();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de usuarios"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $usuario=new UsuarioModel();
        $response=$usuario->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el usuario"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
    }

    public function update()
    {
        //Obtener json enviado
        $inputJSON = file_get_contents('php://input');
        //Decodificar json
        $object = json_decode($inputJSON);
        //Instancia del modelo
        $usuario = new AdminCentroModel();
        //Acción del modelo a ejecutar
        $response = $usuario->update($object);
        //Verificar respuesta
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => "Usuario actualizada"
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No se actualizo el recurso"
            );
        }
        //Escribir respuesta JSON con código de estado HTTP
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }
}