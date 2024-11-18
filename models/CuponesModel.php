<?php
class CuponesModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT *
            FROM cupon
            WHERE CURDATE() BETWEEN FechaInicio AND FechaFinal;";
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
            $vSql = "SELECT * FROM cupon where id=$id";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            if (!empty($vResultado)) {
                //Obtener objeto
                $vResultado = $vResultado[0];
            }

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function create($objeto)
    {
        try {
            //Consulta sql
            //Identificador autoincrementable


            $sql = "Insert into cupon (descripcion,Nombre,idTipoCupon,FechaInicio,FechaFinal,CantidadEcomonedas) Values" .
                "('$objeto->descripcion','$objeto->Nombre','$objeto->TipoCupon','$objeto->FechaInicio', '$objeto->FechaFinal', '$objeto->CantidadEcomonedas');";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idCupon = $this->enlace->executeSQL_DML_last($sql);

            //Retornar material
            return $this->get($idCupon);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($objeto)
    {
        try {
            //Consulta sql            
            $vSql = "update cupon set descripcion ='$objeto->descripcion',Nombre='$objeto->Nombre',
            idTipoCupon ='$objeto->idTipoCupon',FechaInicio ='$objeto->FechaInicio', FechaFinal= '$objeto->FechaFinal', CantidadEcomonedas= '$objeto->CantidadEcomonedas'
                where id = '$objeto->id';";

            //Ejecutar la consulta
            $vResultado = $this->enlace->executeSQL_DML($vSql);
            // Retornar el objeto creado
            return $this->get($objeto->id);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}