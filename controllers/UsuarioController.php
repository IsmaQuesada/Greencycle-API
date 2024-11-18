<?php
//Cargar todos los paquetes
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;
class usuario 
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

    public function getUsuarioBilletera($param){
        
        $usuario=new UsuarioModel();
        $response=$usuario->getUsuarioBilletera($param);
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


    public function usuarioAdminCentro($param){
        
        $usuario=new UsuarioModel();
        $response=$usuario->usuarioAdminCentro($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el administrador"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function usuarioAdmin($param){
        
        $usuario=new UsuarioModel();
        $response=$usuario->usuarioAdmin($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el administrador del centro de acopio"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function usuarioClientes($id)
    {
        $usuario = new UsuarioModel();
        $response = $usuario->getUsuariosClientes($id);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existe el administrador del centro de acopio"
            );
        }
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function getClientes($id)
    {
        $usuario = new UsuarioModel();
        $response = $usuario->getClientes($id);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existe el administrador del centro de acopio"
            );
        }
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function autorize()
    {
        try {

            $token = null;
            $headers = apache_request_headers();
            if (isset($headers['Authentication'])) {
                $matches = array();
                preg_match('/Bearer\s(\S+)/', $headers['Authentication'], $matches);
                if (isset($matches[1])) {
                    $token = $matches[1];
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function login()
    {

        $inputJSON = file_get_contents('php://input');
        $object = json_decode($inputJSON);
        $usuario = new UsuarioModel();
        $response = $usuario->login($object); //valida las credenciales, si son correctas crea el token 
        if (isset($response) && !empty($response) && $response != false) {
            // Datos que desea incluir en el token JWT
            $data = [
                'id' => $response->id,
                'email' => $response->Correo,
                'tipoUsuario' => $response->rol,
            ];
            // Generar el token JWT 
            $jwt_token = JWT::encode($data, $this->secret_key, 'HS256'); //codifica el json el token 
            $json = array(
                'status' => 200,
                'results' => $jwt_token
            );
        } else {
            $json = array(
                'status' => 200,
                'results' => "Usuario no valido"
            );
        }
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function create()
    {
        $inputJSON = file_get_contents('php://input');
        $object = json_decode($inputJSON);
        $usuario = new UsuarioModel();
        $response = $usuario->createUsuario($object);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "Usuario No creado"
            );
        }
        echo json_encode(
            $json,
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
        $usuario = new UsuarioModel();
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