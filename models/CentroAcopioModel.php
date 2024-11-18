        <?php

class CentroAcopioModel
{
    public $enlace;

    public function __construct()
    {
        $this->enlace = new MySqlConnect();
    }

    public function all()
    {
        try {

            $vSql = "SELECT * FROM centroacopio;";
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCentrosActivos($id)
    {
        try {

            $vSql = "SELECT * FROM centroacopio Where estado = $id;";
            $vResultado = $this->enlace->ExecuteSQL($vSql);

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            //admin del centro de acopio
            $usuarioModel = new UsuarioModel();
            $provinciaModel = new ProvinciaModel();
            $CantonModel = new CantonModel();
            $materialCentro = new MaterialModel();

            //Consulta sql
            $vSql = "SELECT * FROM centroacopio where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto
            if (!empty($vResultado)) {
                //Obtener objeto
                $vResultado = $vResultado[0];
                //---usuario 
                $objUsuario = $usuarioModel->get(
                    $vResultado->idUsuario
                );
                //Asignar usuario al objeto 
                $vResultado->usuario = $objUsuario;

                //---Provincia 
                $provinciaObj = $provinciaModel->get(
                    //tambien se puede usar el id del parametro para no hacer todo esto 
                    $vResultado->idProvincia
                );
                //Asignar Provincia al objeto
                $vResultado->Provincia = $provinciaObj[0];

                //---canton 
                $CantonObj = $CantonModel->get(
                    //tambien se puede usar el id del parametro para no hacer todo esto 
                    $vResultado->idCanton
                );
                $vResultado->Canton = $CantonObj[0];

                $ListaDeMateriales = $materialCentro->getMaterialesAcopio(
                    $id
                );

                $vResultado->Materiales = $ListaDeMateriales;
            }

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCentroAcopio($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT * FROM centroacopio where id=$id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*  public function create($objeto)
     {
         try {
             //Consulta sql
             //Identificador autoincrementable

             $sql = "Insert into centroacopio (nombre, idProvincia,idCanton,idUsuario,direccion,telefono,horario) Values" .
                 "('$objeto->nombre','$objeto->Provincia','$objeto->Canton','$objeto->administrador', '$objeto->direccion','$objeto->telefono','$objeto->horario');";

             //Ejecutar la consulta
             //Obtener ultimo insert
             $idMaterial = $this->enlace->executeSQL_DML_last($sql);



             //Retornar material
             return $this->get($idMaterial);
         } catch (Exception $e) {
             die($e->getMessage());
         }
     } */

    public function create($objeto)
    {
        try {
            //Consulta sql
            $sql = "Insert into centroacopio (nombre, idProvincia,idCanton,idUsuario,direccion,telefono,horario,estado) Values" .
                "('$objeto->nombre','$objeto->Provincia','$objeto->Canton','$objeto->administrador', '$objeto->direccion','$objeto->telefono','$objeto->horario','$objeto->Estado');";

            //Ejecutar la consulta
            //Obtener ultimo insert
            $idCentro = $this->enlace->executeSQL_DML_last($sql);
            //--- materiales del centro ---
            //Crear elementos a insertar en materiales acopio
            foreach ($objeto->materiales as $idMaterial) {
                $dataMateriales[] = array($idCentro, $idMaterial);
            }

            foreach ($dataMateriales as $row) {

                $valores = implode(',', $row);
                $sql = "INSERT INTO materialesacopio(idCentroAcopio, idMaterial) VALUES(" . $valores . ");";
                $vResultado = $this->enlace->executeSQL_DML($sql);
            }


            //Retornar Centro Acop
            return $this->get($idCentro);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getForm($id)
    {
        try {

            $materialesM = new MaterialModel();

            $vSql = "SELECT * FROM centroacopio where id=$id";
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            $vResultado = $vResultado[0];


            //Materiales
            $materiales = $materialesM->getMaterialesAcopio($id);

            if (!empty($materiales)) {
                $materiales = array_column($materiales, 'id');
            } else {
                $materiales = [];
            }
            $vResultado->materiales = $materiales;

            $vResultado->Provincia = $vResultado->idProvincia;

            //Canton
            $canton = $vResultado->idCanton;
            $vResultado->Canton = $canton;

            //Admin
            $dataAdmin = $vResultado->idUsuario;
            $vResultado->administrador = $dataAdmin;

            // Retornar el objeto
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($objeto)
    {
        try {
            //Consulta sql

            $sql = "update centroacopio set nombre ='$objeto->nombre',
            idProvincia ='$objeto->idProvincia',idCanton ='$objeto->idCanton',idUsuario ='$objeto->idUsuario',
            direccion='$objeto->direccion', telefono='$objeto->telefono', horario='$objeto->horario', estado='$objeto->Estado'
            Where id=$objeto->id";

            //Ejecutar la consulta
            $cResults = $this->enlace->executeSQL_DML($sql);
            //--- Generos ---
            //Borrar materiales existentes asignados

            $sql = "Delete from materialesacopio Where idCentroAcopio=$objeto->id";
            $cResults = $this->enlace->executeSQL_DML($sql);

            //Crear elementos a insertar en generos
            foreach ($objeto->materiales as $material) {
                $dataMaterial[] = array($objeto->id, $material);
            }

            foreach ($dataMaterial as $row) {
                $valores = implode(',', $row);
                $sql = "INSERT INTO materialesacopio(idCentroAcopio, idMaterial) VALUES(" . $valores . ");";
                $vResultado = $this->enlace->executeSQL_DML($sql);
            }

            return $this->get($objeto->id);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function getCentroAcopioXAdmin($id)
    {
        try {
            //Consulta sql
            $vSql = "SELECT ca.id, ca.nombre as CentroAcopio , us.NombreCompleto as NombreAdmin, us.id as idUsuario 
            From centroacopio ca, usuario us 
            where ca.idUsuario = $id and us.id = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado[0];
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}

