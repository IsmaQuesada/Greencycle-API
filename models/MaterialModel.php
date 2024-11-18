<?php

class MaterialModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM material order by id desc;";
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
			$vSql = "SELECT * FROM material where id=$id";
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

    public function getMaterialesAcopio($id)
    {
        try {
            //Consulta sql
			$vSql = " SELECT m.id, m.Nombre, m.descripcion, m.imagen, m.unidadMedida, m.precio, m.colorHexa
            FROM material m, materialesacopio ma
            WHERE m.id = ma.idMaterial AND ma.idCentroAcopio = $id;";
			
            //Ejecutar la consulta
			$vResultado = $this->enlace->ExecuteSQL ( $vSql);
			// Retornar el objeto
			return $vResultado;
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }

    public function create($objeto) {
        try {
            //Consulta sql
            //Identificador autoincrementable

            
        

            
			$sql = "Insert into material (descripcion,Nombre,unidadMedida,precio,colorHexa) Values".
            "('$objeto->descripcion','$objeto->Nombre','$objeto->unidadMedida','$objeto->precio', '$objeto->colorHexa');";
			
            //Ejecutar la consulta
            //Obtener ultimo insert
			$idMaterial = $this->enlace->executeSQL_DML_last( $sql);

            //Retornar material
            return $this->get($idMaterial);
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }

    public function update($objeto) {
        try {
            //Consulta sql
            
			$sql = "update material set Nombre ='$objeto->Nombre',".
            "descripcion ='$objeto->descripcion',unidadMedida ='$objeto->unidadMedida',precio ='$objeto->precio',".
            "colorHexa='$objeto->colorHexa'". 
            "Where id=$objeto->id";
			
            //Ejecutar la consulta
			$cResults = $this->enlace->executeSQL_DML( $sql);
            
            //Retornar material
            return $this->get($objeto->id);
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
    }
}