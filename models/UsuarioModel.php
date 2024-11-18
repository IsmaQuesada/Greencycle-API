<?php
class UsuarioModel
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

    public function AdminCentroAcopio()
    {
        try {
            //Consulta sql
            $vSql = "SELECT DISTINCT u.NombreCompleto, u.id, u.Contrasena, u.idTipoUsuario,u.Correo,u.telefono,u.idProvincia,
            u.idCanton,u.idDistrito
            FROM usuario u
            INNER JOIN tipousuario tu ON u.idTipoUsuario = tu.id
            LEFT JOIN centroacopio c ON u.id = c.idUsuario
            WHERE tu.descripcion LIKE '%Administrador centro acopio%' AND c.idUsuario IS NULL"; //si se quita el is null aparece precargado el admin

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            // Retornar el objeto

            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function usuarioAdmin($id) //se usa para obtener el usuario del centro asociado
    {
        try {
            //Consulta sql
            $vSql = "SELECT DISTINCT u.NombreCompleto, u.id, u.Contrasena, u.idTipoUsuario,u.Correo,u.telefono,u.idProvincia,u.idCanton,u.idDistrito
            FROM usuario u
            INNER JOIN tipousuario tu ON u.idTipoUsuario = tu.id
            LEFT JOIN centroacopio c ON u.id = c.idUsuario
            WHERE tu.descripcion LIKE '%Administrador centro acopio%' AND c.idUsuario IS NULL
            UNION
            SELECT u.NombreCompleto, u.id, u.Contrasena, u.idTipoUsuario,u.Correo,u.telefono,u.idProvincia,u.idCanton,u.idDistrito
            FROM USUARIO u, centroacopio ca
            WHERE u.id = ca.idUsuario AND ca.id =$id AND u.idTipoUsuario = (SELECT id FROM tipousuario WHERE descripcion LIKE '%Administrador centro acopio%')";


            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function usuarioAdminCentro($id) //se usa para obtener el usuario del centro asociado
    {
        try {
            //Consulta sql
            $vSql = "SELECT DISTINCT u.NombreCompleto, u.id, u.Contrasena, u.idTipoUsuario,u.Correo,u.telefono,u.idProvincia,u.idCanton,u.idDistrito
            FROM usuario u
            INNER JOIN tipousuario tu ON u.idTipoUsuario = tu.id
            LEFT JOIN centroacopio c ON u.id = c.idUsuario
            WHERE tu.id = $id";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getUsuariosClientes($id) //se usa para obtener el usuario del centro asociado
    {
        try {
            //Consulta sql
            $vSql = "SELECT us.NombreCompleto, us.Correo, us.id
            FROM usuario us
            INNER JOIN tipousuario tp ON us.idTipoUsuario = tp.id
            WHERE us.idTipoUsuario = $id";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);


            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getClientes($id) //se usa para obtener el usuario del centro asociado
    {
        try {
            //Consulta sql
            $vSql = " SELECT us.NombreCompleto, us.Correo, us.id, us.Telefono, p.descripcion as provincia, c.descripcion as canton, 
            d.descripcion as distrito
            FROM usuario us
            INNER JOIN provincia p ON us.idProvincia = p.id
			INNER JOIN canton c ON us.idCanton = c.id
            INNER JOIN distrito d ON us.idDistrito = d.id

            WHERE us.idTipoUsuario = $id";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);


            return $vResultado;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function login($objeto)
    {
        try {

            $vSql = "SELECT * from usuario where correo='$objeto->email'";

            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if (is_object($vResultado[0])) {
                $user = $vResultado[0];
                if (password_verify($objeto->password, $user->Contrasena)) {
                    return $this->get($user->id);
                }

            } else {
                return false;
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function createUsuario($objeto)
    {
        try {
            if (isset($objeto->password) && $objeto->password != null) {
                $crypt = password_hash($objeto->password, PASSWORD_BCRYPT);
                $objeto->password = $crypt;
            }
            //Consulta sql            
            $vSql = "Insert into usuario (NombreCompleto, Contrasena, idTipoUsuario, Correo, Telefono, idProvincia, idCanton, idDistrito)" .
                " Values ('$objeto->NombreCompleto','$objeto->password','$objeto->idTipoUsuario','$objeto->Correo','$objeto->Telefono', '$objeto->Provincia','$objeto->Canton','$objeto->Distrito')";

            //Ejecutar la consulta
            $vResultado = $this->enlace->executeSQL_DML_last($vSql);
            // Retornar el objeto creado
            return $this->get($vResultado);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($objeto)
    {
        try {

            if (isset($objeto->password) && $objeto->password != null) {
                $crypt = password_hash($objeto->password, PASSWORD_BCRYPT);
                $objeto->password = $crypt;
            }
            //Consulta sql            
            $vSql = "update usuario set Contrasena ='$objeto->password' where id = '$objeto->idUsuario';";

            //Ejecutar la consulta
            $vResultado = $this->enlace->executeSQL_DML($vSql);
            // Retornar el objeto creado
            return $this->get($objeto->idUsuario);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getUsuarioBilletera($id)
    {
        try {

            //Consulta sql
            $vSql = "SELECT u.NombreCompleto, u.Correo, bt.disponible
            FROM usuario u
            JOIN billeteravirtual bt ON u.id = bt.idUsuario
            WHERE u.id = $id;";
            //Ejecutar la consulta
            $vResultado = $this->enlace->ExecuteSQL($vSql);
            if ($vResultado) {
                $vResultado = $vResultado[0];
                // Retornar el objeto
                return $vResultado;
            } else {
                return null;
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}