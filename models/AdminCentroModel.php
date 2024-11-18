<?php
class AdminCentroModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {
            $vSql = "SELECT * FROM usuario order by NombreCompleto asc;";
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $rolM = new TipoUsuarioModel();

            //Consulta sql
            $vSql = "SELECT * FROM usuario where id=$id";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if ($vResultado) {
                $vResultado = $vResultado[0];
                $rol = $rolM->getRolUser($id);
                $vResultado->rol = $rol;
                // Retornar el objeto
                return $vResultado;
            } else {
                return null;
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function update($objeto)
    {
        try {
            //Consulta sql            
            $vSql = "update usuario set NombreCompleto ='$objeto->NombreCompleto',Correo='$objeto->Correo',
                Telefono ='$objeto->Telefono',idProvincia ='$objeto->idProvincia', idCanton= '$objeto->idCanton', idDistrito= '$objeto->idDistrito'
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