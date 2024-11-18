<?php
class ReportesModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM centroacopio order by nombre asc;";
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCantCanjesMesActual($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT
            COUNT(*) AS CantidadCanjesMateriales
             FROM
            canjeomateriales cm
            INNER JOIN usuario u ON u.id = $id
            INNER JOIN centroacopio ca ON u.id = ca.idUsuario AND ca.id = cm.idCentroAcopio
            WHERE
            YEAR(cm.Fecha) = YEAR(CURDATE())
            AND (
                (MONTH(cm.Fecha) = MONTH(CURDATE()) AND YEAR(cm.Fecha) = YEAR(CURDATE()))
                OR
                (MONTH(cm.Fecha) = MONTH(NOW()) AND YEAR(cm.Fecha) = YEAR(NOW()))
            );";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCantCanjesXmaterialAnnioActual($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT
            dm.idMaterial,
            m.descripcion, 
            COUNT(*) AS CantidadCanjes
            FROM
            canjeomateriales cm, centroacopio ca, 
            usuario u, detallecanjeomateriales dm, material m
            WHERE
            YEAR(cm.Fecha) = YEAR(CURDATE())
            AND m.id = dm.idMaterial
            AND dm.idCanjeo = cm.id
            AND cm.idCentroAcopio = ca.id
            AND ca.idUsuario = u.id
            AND u.id = $id
            GROUP BY
            dm.idMaterial, m.descripcion;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getTotalGenerado($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT ca.nombre, SUM(cm.TotalEcoMoneda) as TotalGenerado
            FROM canjeomateriales cm, usuario u, centroacopio ca
            WHERE u.id = $id and u.id = ca.idUsuario and ca.id = cm.idCentroAcopio;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //reportes del admin
    public function getTotalMonedasXCentro($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT
            cm.idCentroAcopio,
            SUM(TotalEcoMoneda) AS TotalEcoMonedaGenerada, ca.nombre
            FROM
            canjeomateriales cm, centroacopio ca
            WHERE
            YEAR(Fecha) = YEAR(CURDATE()) and ca.id = cm.idCentroAcopio
            GROUP BY
            idCentroAcopio;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCantTotalCanjesDelMes($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT
            COUNT(*) AS CantidadCanjeMateriales
            FROM
            canjeomateriales
            WHERE
            YEAR(Fecha) = YEAR(CURDATE()) AND
            MONTH(Fecha) = MONTH(CURDATE());";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getEstadisticaMonedasXcentroAnnioActual($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT
            cm.idCentroAcopio,
            ca.nombre,
            COUNT(*) AS TotalCanjeMateriales,
            SUM(cm.TotalEcoMoneda) AS SumaTotalEcoMoneda,
            AVG(cm.TotalEcoMoneda) AS PromedioEcoMoneda,
            MAX(cm.TotalEcoMoneda) AS MaxEcoMoneda,
            MIN(cm.TotalEcoMoneda) AS MinEcoMoneda
            FROM
            canjeomateriales cm, centroacopio ca
            WHERE
            YEAR(Fecha) = YEAR(CURDATE())
            AND ca.id = cm.idCentroAcopio
            GROUP BY
            idCentroAcopio;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCantCanjesCuponesAnnioActual($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT COUNT(*) AS CantidadCanjes
            FROM cuponusuario
            WHERE YEAR(fechaCanjeo) = YEAR(CURDATE());";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getTotalEcomonedasUtilizadasEnAnioActual($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT SUM(canjeados) as totalCanjeado
            FROM billeteravirtual;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}