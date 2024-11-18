<?php

class CuponUsuarioModel
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
            $vSql = "SELECT * FROM cuponusuario where idUsuario=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCuponByIdUsuario($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT
            cp.Nombre,
            cp.descripcion,
            cp.CantidadEcomonedas,
            cp.FechaInicio,
            cp.FechaFinal,
            tp.descripcion as tipoCupon
        FROM
            cuponusuario cs
        JOIN
            cupon cp ON cs.idCupon = cp.id
        JOIN
            tipocupon tp ON cp.idTipoCupon = tp.id
        WHERE
            cs.idUsuario = $id; ";

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
            $vSql = "SELECT * FROM billeteravirtual Where idUsuario = $objeto->idUsuario;";
            $UsuarioBilletera = $this->enlace->ExecuteSQL($vSql);

            if ($UsuarioBilletera) {
                $vSql = "UPDATE billeteravirtual SET disponible = disponible - $objeto->total, canjeados = canjeados + $objeto->total 
                WHERE idUsuario = '$objeto->idUsuario'";
                $billeteraUpdate = $this->enlace->executeSQL_DML_last($vSql);
            }

            //--- Generos ---
            //Crear elementos a insertar en cupon
            foreach ($objeto->cupones as $cupon) {
                $dataDetalle[] = array($objeto->idUsuario, $cupon->cupon_id, "'" . $objeto->fecha . "'");
            }

            foreach ($dataDetalle as $row) {
                $valores = implode(',', $row);
                $sql = "INSERT into cuponusuario(idUsuario,idCupon,fechaCanjeo) VALUES(" . $valores . ");";
                $vResultado = $this->enlace->executeSQL_DML($sql);
            }

            return $this->getIDCupon($objeto->idUsuario);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getIDCupon($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT *
            from cuponusuario cm
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