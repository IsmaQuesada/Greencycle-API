<?php

class detalleCanjeoMaterialModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM detallecanjeomateriales order by id desc;";
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
            $vSql = "SELECT * FROM detallecanjeomateriales where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getByIDCanjeo($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT dm.id,dm.idCanjeo,dm.idMaterial,dm.cantidad,dm.precio,dm.subTotal, m.descripcion
            FROM detallecanjeomateriales dm, material m
            where dm.idCanjeo= $id and dm.idMaterial = m.id";

            
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}