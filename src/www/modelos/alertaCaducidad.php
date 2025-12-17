<?php
/**
 * Modelo AlertaCaducidad
 */
require_once __DIR__ . '/bd.php';

class AlertaCaducidad {
    private $id;
    private $nombre_producto;
    private $punto_distribucion_id;
    private $cantidad;
    private $fecha_caducidad;
    private $dias_restantes;
    private $ubicacion;
    private $estado;
    private $created_at;

    public function __construct($nombre_producto, $punto_distribucion_id, $cantidad, $fecha_caducidad, $ubicacion) {
        $this->nombre_producto = $nombre_producto;
        $this->punto_distribucion_id = $punto_distribucion_id;
        $this->cantidad = $cantidad;
        $this->fecha_caducidad = $fecha_caducidad;
        $this->ubicacion = $ubicacion;
        $this->calcularDiasRestantes();
        $this->determinarEstado();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombreProducto() { return $this->nombre_producto; }
    public function getPuntoDistribucionId() { return $this->punto_distribucion_id; }
    public function getCantidad() { return $this->cantidad; }
    public function getFechaCaducidad() { return $this->fecha_caducidad; }
    public function getDiasRestantes() { return $this->dias_restantes; }
    public function getUbicacion() { return $this->ubicacion; }
    public function getEstado() { return $this->estado; }
    public function getCreatedAt() { return $this->created_at; }

    private function calcularDiasRestantes() {
        $ahora = new DateTime();
        $fechaExpiracion = new DateTime($this->fecha_caducidad);
        $diferencia = $ahora->diff($fechaExpiracion);
        
        if ($diferencia->invert) {
            $this->dias_restantes = -$diferencia->days;
        } else {
            $this->dias_restantes = $diferencia->days;
        }
    }

    private function determinarEstado() {
        if ($this->dias_restantes < 0) {
            $this->estado = 'caducado';
        } elseif ($this->dias_restantes <= 3) {
            $this->estado = 'critico';
        } elseif ($this->dias_restantes <= 7) {
            $this->estado = 'urgente';
        } elseif ($this->dias_restantes <= 15) {
            $this->estado = 'proximo';
        } else {
            $this->estado = 'ok';
        }
    }

    private static function asegurarTabla(BD $bd) {
        $sql = "CREATE TABLE IF NOT EXISTS alertas_caducidad (
            id INT(11) NOT NULL AUTO_INCREMENT,
            nombre_producto VARCHAR(255) NOT NULL,
            punto_distribucion_id INT(11) NOT NULL,
            cantidad INT(11) NOT NULL,
            fecha_caducidad DATE NOT NULL,
            ubicacion VARCHAR(255) NOT NULL,
            estado VARCHAR(50) DEFAULT 'ok',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY punto_distribucion_id (punto_distribucion_id),
            CONSTRAINT alertas_caducidad_ibfk_1 FOREIGN KEY (punto_distribucion_id) REFERENCES puntos_distribucion (id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        $bd->seleccionar($sql);
    }

    public function guardar() {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);

            $sql = "INSERT INTO alertas_caducidad (nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicacion, estado, created_at) 
                    VALUES (:nombre_producto, :punto_distribucion_id, :cantidad, :fecha_caducidad, :ubicacion, :estado, NOW())";
            $params = [
                ':nombre_producto' => $this->nombre_producto,
                ':punto_distribucion_id' => $this->punto_distribucion_id,
                ':cantidad' => $this->cantidad,
                ':fecha_caducidad' => $this->fecha_caducidad,
                ':ubicacion' => $this->ubicacion,
                ':estado' => $this->estado
            ];
            $this->id = $bd->insertar($sql, $params);
            $this->created_at = date('Y-m-d H:i:s');

            return $this->id;
        } catch (Throwable $exception) {
            throw new Exception("Error al guardar alerta de caducidad: " . $exception->getMessage());
        }
    }

    public static function listar() {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);
            $sql = "SELECT * FROM alertas_caducidad ORDER BY fecha_caducidad ASC, id DESC";
            $filas = $bd->seleccionar($sql);
            $lista = [];
            foreach ($filas as $fila) {
                $alerta = new AlertaCaducidad(
                    $fila['nombre_producto'],
                    $fila['punto_distribucion_id'],
                    $fila['cantidad'],
                    $fila['fecha_caducidad'],
                    $fila['ubicacion']
                );
                $alerta->id = $fila['id'];
                $alerta->estado = $fila['estado'];
                $alerta->created_at = $fila['created_at'];
                $lista[] = $alerta;
            }
            return $lista;
        } catch (Throwable $exception) {
            throw new Exception("Error al listar alertas: " . $exception->getMessage());
        }
    }

    public static function obtenerPorId($id) {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);
            $sql = "SELECT * FROM alertas_caducidad WHERE id = :id";
            $params = [':id' => $id];
            $filas = $bd->seleccionar($sql, $params);
            
            if (empty($filas)) {
                return null;
            }
            
            $fila = $filas[0];
            $alerta = new AlertaCaducidad(
                $fila['nombre_producto'],
                $fila['punto_distribucion_id'],
                $fila['cantidad'],
                $fila['fecha_caducidad'],
                $fila['ubicacion']
            );
            $alerta->id = $fila['id'];
            $alerta->estado = $fila['estado'];
            $alerta->created_at = $fila['created_at'];
            
            return $alerta;
        } catch (Throwable $exception) {
            throw new Exception("Error al obtener alerta: " . $exception->getMessage());
        }
    }

    public static function eliminar($id) {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);
            $sql = "DELETE FROM alertas_caducidad WHERE id = :id";
            $params = [':id' => $id];
            return $bd->borrar($sql, $params);
        } catch (Throwable $exception) {
            throw new Exception("Error al eliminar alerta: " . $exception->getMessage());
        }
    }

    public static function obtenerAlertas($filtro = 'todas') {
        try {
            $alertas = AlertaCaducidad::listar();
            $hoy = new DateTime();
            $resultado = [];
            
            foreach ($alertas as $alerta) {
                $fecha = new DateTime($alerta->fecha_caducidad);
                $diff = $hoy->diff($fecha);
                $dias = $diff->invert ? -$diff->days : $diff->days;
                
                switch ($filtro) {
                    case 'criticas':
                        if ($dias >= 0 && $dias <= 3) {
                            $resultado[] = $alerta;
                        }
                        break;
                    case 'caducadas':
                        if ($dias < 0) {
                            $resultado[] = $alerta;
                        }
                        break;
                    case 'proximas':
                        if ($dias > 3 && $dias <= 15) {
                            $resultado[] = $alerta;
                        }
                        break;
                    default:
                        $resultado[] = $alerta;
                }
            }
            
            return $resultado;
        } catch (Throwable $exception) {
            throw new Exception("Error al obtener alertas filtradas: " . $exception->getMessage());
        }
    }

    public static function buscarPorPuntoDistribucion($puntoId) {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);
            $sql = "SELECT * FROM alertas_caducidad WHERE punto_distribucion_id = :punto_id ORDER BY fecha_caducidad ASC";
            $params = [':punto_id' => $puntoId];
            $filas = $bd->seleccionar($sql, $params);
            $lista = [];
            foreach ($filas as $fila) {
                $alerta = new AlertaCaducidad(
                    $fila['nombre_producto'],
                    $fila['punto_distribucion_id'],
                    $fila['cantidad'],
                    $fila['fecha_caducidad'],
                    $fila['ubicacion']
                );
                $alerta->id = $fila['id'];
                $alerta->estado = $fila['estado'];
                $alerta->created_at = $fila['created_at'];
                $lista[] = $alerta;
            }
            return $lista;
        } catch (Throwable $exception) {
            throw new Exception("Error al buscar alertas por punto de distribución: " . $exception->getMessage());
        }
    }
}
?>
