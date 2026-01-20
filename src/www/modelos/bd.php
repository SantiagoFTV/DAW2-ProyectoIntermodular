<?php
class BD {
    private $conexion;

    public function __construct() {
        try {
            $config = [
                'bd_host' => 'localhost',
                'bd_nombre' => 'sprint',
                'bd_usuario' => 'root',
                'bd_clave' => ''
            ];
            
            $host = $config['bd_host'];
            $nombre = $config['bd_nombre'];
            $usuario = $config['bd_usuario'];
            $clave = $config['bd_clave'];
            
            $stringConexion = "mysql:host=$host;dbname=$nombre;charset=utf8";
            
            $this->conexion = new PDO($stringConexion, $usuario, $clave);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // No imprimimos mensajes desde la clase de acceso a datos: mantenerla sin efectos secundarios
            
        } catch (PDOException $exception) {
            throw new Exception("Error en bd.php: " . $exception->getMessage());
        }
    }

    public function insertar($sql, $parametros = []) {
        try {
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute($parametros);
            return $this->conexion->lastInsertId();
        } catch (PDOException $exception) {
            throw new Exception("Error al insertar: " . $exception->getMessage());
        }
    }

    public function seleccionar($sql, $parametros = []) {
        try {
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia->fetchAll();
        } catch (PDOException $exception) {
            throw new Exception("Error al seleccionar: " . $exception->getMessage());
        }
    }

    public function ejecutar($sql, $parametros = []) {
        try {
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia->rowCount();
        } catch (PDOException $exception) {
            throw new Exception("Error al ejecutar: " . $exception->getMessage());
        }
    }
}
?>