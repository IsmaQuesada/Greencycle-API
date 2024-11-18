<?php

class BilleteraVirtualModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM billeteravirtual order by id desc;";
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
			$vSql = "SELECT * FROM billeteravirtual where id=$id";
            //Ejecutar la consulta
			$vResultado = $this->enlace->ExecuteSQL ( $vSql);
			
            if(!empty($vResultado)){
                //Obtener objeto
                $vResultado = $vResultado[0];
            }

			return $vResultado;
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }

    public function getByIdUsuario($id)
    {
        try {
            //Consulta sql
			$vSql = "SELECT * FROM billeteravirtual where idUsuario=$id";
            //Ejecutar la consulta
			$vResultado = $this->enlace->ExecuteSQL ( $vSql);
			
            if(!empty($vResultado)){
                //Obtener objeto
                $vResultado = $vResultado[0];
            }

			return $vResultado;
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }
}