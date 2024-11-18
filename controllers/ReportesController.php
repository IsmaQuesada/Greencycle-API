<?php
class Reportes
{
    public function index()
    {
        $admin = new ReportesModel();

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

    public function getCantCanjesMesActual($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getCantCanjesMesActual($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    public function getCantCanjesXmaterialAnnioActual($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getCantCanjesXmaterialAnnioActual($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    public function getTotalGenerado($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getTotalGenerado($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    //admin
    public function getTotalMonedasXCentro($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getTotalMonedasXCentro($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    public function getCantTotalCanjesDelMes($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getCantTotalCanjesDelMes($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );
    }

    public function getEstadisticaMonedasXcentroAnnioActual($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getEstadisticaMonedasXcentroAnnioActual($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    public function getCantCanjesCuponesAnnioActual($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getCantCanjesCuponesAnnioActual($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }

    public function getTotalEcomonedasUtilizadasEnAnioActual($param)
    {
        $admin = new ReportesModel();
        $response = $admin->getTotalEcomonedasUtilizadasEnAnioActual($param);
        if (isset($response) && !empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response,
            );
        } else {
            $json = array(
                'status' => 400,
                'results' => "No existen registros de canjeos"
            );
        }
        echo json_encode($json,
            http_response_code($json["status"])
        );

    }
}