<?php
class TipoCupones
{
    public function index()
    {
        $admin = new TipoCuponModel();

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

    
}
