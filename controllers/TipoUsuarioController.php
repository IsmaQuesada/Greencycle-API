<?php
class tipoUsuario{
    public function get($param){
        
        $tipo=new TipoUsuarioModel();
        $response=$tipo->get($param);
        if(isset($response) && !empty($response)){
            $json=array(
                'status'=>200,
                'results'=>$response,
            );
        }else{
            $json=array(
                'status'=>400,
                'results'=>"No existe el actor"
            );
        }
        echo json_encode($json,
                http_response_code($json["status"])
            );
        
    }
}