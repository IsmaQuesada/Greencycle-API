<?php

class distrito 
{
    public function index()
    {
        $distrito = new DistritoModel();

        $response = $distrito->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de distritos"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $distrito=new DistritoModel();
        $response=$distrito->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el distrito"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
    }

    public function getDistritoByCanton($param){
        
        $distrito=new DistritoModel();
        $response=$distrito->getDistritoByCanton($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el distrito"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }
}