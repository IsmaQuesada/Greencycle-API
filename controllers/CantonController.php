<?php

class canton 
{
    public function index()
    {
        $canton = new CantonModel();

        $response = $canton->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de cantons"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $canton=new CantonModel();
        $response=$canton->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe la canton"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function getCantonByIdProvincia($param){
        
        $canton=new CantonModel();
        $response=$canton->getCantonByIdProvincia($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe la canton"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
    }
}