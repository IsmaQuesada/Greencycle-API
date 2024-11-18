<?php

class centroAcopio 
{
    public function index()
    {
        $Acopio = new CentroAcopioModel();

        $response = $Acopio->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de centros de acopio"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $Acopio=new CentroAcopioModel();
        $response=$Acopio->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el centro de acopio"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function getCentrosActivos($param){
        
        $Acopio=new CentroAcopioModel();
        $response=$Acopio->getCentrosActivos($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el centro de acopio"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function create()
    {
        //Obtener json enviado
        $inputJSON = file_get_contents('php://input');
        //Decodificar json
        $object = json_decode($inputJSON);
        //Instancia del modelo
        $centro = new CentroAcopioModel();
        //Acción del modelo a ejecutar
        $response = $centro->create($object);
        //Verificar respuesta
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => 'Centro de acopio creado'
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No se creo el recurso"
            );
        }
        //Escribir respuesta JSON con código de estado HTTP
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
        $centro = new CentroAcopioModel();
        //Acción del modelo a ejecutar
        $response = $centro->update($object);
        //Verificar respuesta
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => "Centro de acopio actualizada"
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

    public function getForm($id)
    {
        //Instancia del modelo
        $centroAcopio = new CentroAcopioModel();
        $json = array(
            'status' => 400,
            'results' => "Solicitud sin identificador"
        );
        //Verificar párametro
        if (isset($id) && !empty($id) && $id !== 'undefined' && $id !== 'null') {
            //Acción del modelo a ejecutar
            $response = $centroAcopio->getForm($id);
            //Verificar respuesta
            if (isset($response) && !empty($response)) {
                //Armar el json
                $json = array(
                    'status' => 200,
                    'results' => $response
                );
            } else {
                $json = array(
                    'status' => 400,
                    'results' => "No existe el recurso solicitado"
                );
            }

        }
        //Escribir respuesta JSON con código de estado HTTP
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function getCentroAcopioXAdmin($param){
        
        $Acopio=new CentroAcopioModel();
        $response=$Acopio->getCentroAcopioXAdmin($param);
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
}