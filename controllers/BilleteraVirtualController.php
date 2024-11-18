<?php

class billeteraVirtual 
{
    public function index()
    {
        $billetera = new BilleteraVirtualModel();

        $response = $billetera->all();
        if(isset($response) && !empty($response)){
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No hay registros de billetera virtual"
            );
        }

        echo json_encode(
            $json,
            http_response_code($json["status"])
        );
    }

    public function get($param){
        
        $billetera = new BilleteraVirtualModel();
        $response=$billetera->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe la billetera virtual"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }

    public function getByIdUsuario($param){
        
        $billetera = new BilleteraVirtualModel();
        $response=$billetera->getByIdUsuario($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe la billetera virtual del usuario"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }
}