<?php

class canjeoMaterialModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM canjeomateriales order by id desc;";
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT 
            cm.id, 
            cm.Fecha, 
            cm.idUsuario, 
            us.NombreCompleto as Nombre, 
            cm.idCentroAcopio, 
            cm.TotalEcoMoneda, 
            cp.nombre as nombreAcopio,
            p.descripcion as provincia,
            c.descripcion as canton
        FROM 
            canjeomateriales cm
        JOIN 
            usuario us ON cm.idUsuario = us.id
        JOIN 
            centroacopio cp ON cm.idCentroAcopio = cp.id
        JOIN 
            provincia p ON cp.idProvincia = p.id
        JOIN 
            canton c ON cp.idCanton = c.id
        WHERE 
            us.id = $id;
        ";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getdetalle($idCanjeo)
    {
        try {
            $centroAcopioModel = new centroAcopioModel();
            $detalleCanjeo = new detalleCanjeoMaterialModel();
            $usuarioModel = new usuarioModel();

            //Consulta sql
            $vSql = "SELECT 
            cm.id, 
            cm.Fecha, 
            cm.idUsuario, 
            cm.idCentroAcopio, 
            cm.TotalEcoMoneda,
            p.descripcion as provincia,
            c.descripcion as canton
        FROM 
            canjeomateriales cm
        JOIN 
            centroacopio cp ON cm.idCentroAcopio = cp.id
        JOIN 
            provincia p ON cp.idProvincia = p.id
        JOIN 
            canton c ON cp.idCanton = c.id
        WHERE 
            cm.id = $idCanjeo;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            if (!empty($vResultado)) {
                //Obtener objeto
                $vResultado = $vResultado[0];
                //---centro de acopio
                $objCentroAcopio = $centroAcopioModel->getCentroAcopio(
                    $vResultado->idCentroAcopio
                );
                //Asignar centro de acopio al objeto 
                $vResultado->centroAcopio = $objCentroAcopio[0];

                //---usuario
                $objUsuario = $usuarioModel->get(
                    $vResultado->idUsuario
                );
                //Asignar el usuario al objeto 
                $vResultado->usuario = $objUsuario;

                //materiales
                $ListaMaterialesCanjeados = $detalleCanjeo->getByIDCanjeo(
                    $vResultado->id
                );
                //materialesCanjeados
                $vResultado->materialesCanjeados = $ListaMaterialesCanjeados;
            }

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getHistorialMaterialAcopio($id)
    {

        try {
            //Consulta sql
            $vSql = "SELECT cm.id, cm.Fecha, cm.idUsuario AS idCliente, 
            us.NombreCompleto AS NombreCliente, cm.idCentroAcopio, 
            cm.TotalEcoMoneda, cp.nombre, p.descripcion AS provincia, 
            c.descripcion AS canton, cp.idUsuario AS idAdmin, 
            us_admin.NombreCompleto AS nombreAdmin
            FROM canjeomateriales cm
            JOIN usuario us ON us.id = cm.idUsuario
            JOIN centroacopio cp ON cm.idCentroAcopio = cp.id
            JOIN provincia p ON cp.idProvincia = p.id
            JOIN canton c ON cp.idCanton = c.id
            JOIN usuario us_admin ON cp.idUsuario = us_admin.id
            WHERE us_admin.id <> cm.idUsuario AND cp.idUsuario = $id;";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getMaterialesCentro($id)
    {

        try {
            //Consulta sql
            $vSql = "SELECT m.Nombre AS nombreMaterial, m.id, m.precio, m.descripcion
            FROM materialesacopio ma
            JOIN material m ON ma.idMaterial = m.id
            WHERE ma.idCentroAcopio = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function create($objeto)
    {
        try {
            //verificamos si ese usuario ya tiene una billetera 
            $vSql = "SELECT * FROM billeteravirtual Where idUsuario = $objeto->NombreCompleto;";
            $UsuarioBilletera = $this->enlace->ExecuteSQL($vSql);

            if (!$UsuarioBilletera) {
                $sql = "Insert into billeteravirtual(idUsuario,disponible,canjeados,recibidos)" .
                    "Values ('$objeto->NombreCompleto','$objeto->total',0,'$objeto->total')";
                $billeteraInsert = $this->enlace->executeSQL_DML($sql);

            } else {
                $vSql = "UPDATE billeteravirtual SET disponible = disponible + $objeto->total, recibidos = recibidos + $objeto->total 
                WHERE idUsuario = '$objeto->NombreCompleto'";
                $billeteraUpdate = $this->enlace->executeSQL_DML($vSql);
            }

            //fecha desde el php
            $zona_horaria_costa_rica = new DateTimeZone('America/Costa_Rica');
            $fecha_actual_costa_rica = new DateTime('now', $zona_horaria_costa_rica);
            $fechaActual = $fecha_actual_costa_rica->format("Y-m-d H:i:s");

            //Consulta sql
            //Identificador autoincrementable

            $sql = "Insert into canjeomateriales(Fecha,idUsuario,idCentroAcopio,TotalEcoMoneda)" .
                "Values ('$fechaActual','$objeto->NombreCompleto','$objeto->idCentro','$objeto->total')";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idCanjeo = $this->enlace->executeSQL_DML_last($sql);
            //--- Generos ---
            //Crear elementos a insertar en detalle canjeo
            foreach ($objeto->materiales as $detalle) {
                $dataDetalle[] = array($idCanjeo, $detalle->material_id, $detalle->cantidad, $detalle->precio, $detalle->subTotal);
            }

            foreach ($dataDetalle as $row) {

                $valores = implode(',', $row);
                $sql = "INSERT into detallecanjeomateriales(idCanjeo,idMaterial,cantidad,precio,subTotal) VALUES(" . $valores . ");";
                $vResultado = $this->enlace->executeSQL_DML($sql);
            }

            //Retornar canjeo
            return $this->getIDCanjeo($objeto->NombreCompleto);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getIDCanjeo($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT max(cm.id) as idCanjeo 
            from canjeomateriales cm
            where cm.idUsuario = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado[0];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}