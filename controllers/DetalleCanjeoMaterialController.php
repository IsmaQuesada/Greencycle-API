<?php

class detalleCanjeoMaterial 
{
    public function index()
    {
        $canjeoMaterial = new detalleCanjeoMaterialModel();

        $response = $canjeoMaterial->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros del detalle del canjeo del material"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $canjeoMaterial =new detalleCanjeoMaterialModel();
        $response = $canjeoMaterial->get($param);
        if(isset($response) && !empty($response)){
            $json = array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json = array(
                'status'=>400,
                'results'=>"No existe el detalle del canjeo del material"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function getByIDCanjeo($param){
        
        $canjeoMaterial =new detalleCanjeoMaterialModel();
        $response = $canjeoMaterial->getByIDCanjeo($param);
        if(isset($response) && !empty($response)){
            $json = array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json = array(
                'status'=>400,
                'results'=>"No existe el detalle del canjeo"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
    }
}