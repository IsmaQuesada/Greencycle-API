<?php

class canjeoMaterial
{
    public function index()
    {
        $canjeoMaterial = new CanjeoMaterialModel();

        $response = $canjeoMaterial->all();
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros del canjeo del material"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param)
    {

        $canjeoMaterial = new CanjeoMaterialModel();
        $response = $canjeoMaterial->get($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existe el canjeo del material"
            );
        }
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );

    }

    public function getdetalle($param)
    {
        $canjeoMaterial = new CanjeoMaterialModel();
        $response = $canjeoMaterial->getdetalle($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existe el canjeo del material"
            );
        }
        http_response_code($json["status"]);
        echo json_encode($json);
    }

    public function getHistorialMaterialAcopio($param)
    {
        $canjeoMaterial = new CanjeoMaterialModel();
        $response = $canjeoMaterial->getHistorialMaterialAcopio($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existe el historial de canjeos"
            );
        }
        http_response_code($json["status"]);
        echo json_encode($json);
    }

    public function getMaterialesCentro($param)
    {
        $canjeoMaterial = new CanjeoMaterialModel();
        $response = $canjeoMaterial->getMaterialesCentro($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen materiales en el centro"
            );
        }
        http_response_code($json["status"]);
        echo json_encode($json);
    }

    public function create()
    {
        //Obtener json enviado
        $inputJSON = file_get_contents('php://input');
        //Decodificar json
        $object = json_decode($inputJSON);
        //Instancia del modelo
        $canjeo = new canjeoMaterialModel();
        //Acción del modelo a ejecutar
        $response = $canjeo->create($object);
        //Verificar respuesta
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => 'Se ha realizado el canjeo!',
                'canjeo' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No se realizo el canjeo"
            );
        }
        //Escribir respuesta JSON con código de estado HTTP
        echo json_encode(
            $json,
            http_response_code($json["status"])
        );

    }
}