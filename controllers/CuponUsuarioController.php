<?php
class CuponesUsuario
{
    public function index()
    {
        $admin = new CuponUsuarioModel();

        $response = $admin->all();
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de centros"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $usuario=new CuponUsuarioModel();
        $response=$usuario->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el cupón"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );  
    }

    public function getCuponByIdUsuario($param){
        
        $usuario=new CuponUsuarioModel();
        $response=$usuario->getCuponByIdUsuario($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el cupón"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );  
    }


    public function create()
    {
        $inputJSON = file_get_contents('php://input');
        $object = json_decode($inputJSON);
        $usuario = new CuponUsuarioModel();
        $response = $usuario->create($object);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No se realizo el Canje"
            );
        }
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    /* public function update()
    {
        //Obtener json enviado
        $inputJSON = file_get_contents('php://input');
        //Decodificar json
        $object = json_decode($inputJSON);
        //Instancia del modelo
        $material = new CuponesModel();
        //Acción del modelo a ejecutar
        $response = $material->update($object);
        //Verificar respuesta
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => "Cupón actualizada"
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
    } */
}
