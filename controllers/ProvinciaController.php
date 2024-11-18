<?php

class provincia 
{
    public function index()
    {
        $provincia = new ProvinciaModel();

        $response = $provincia->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de provincias"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $provincia=new ProvinciaModel();
        $response=$provincia->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe la provincia"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }
}