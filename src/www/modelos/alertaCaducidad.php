<?php
/**
 * Modelo AlertaCaducidad (Versión CSV)
 * Sistema provisional que usa archivos CSV en lugar de base de datos
 */

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

    private function asegurarArchivo() {
        $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
        
        if (!file_exists($csvPath)) {
            $header = "id,nombre_producto,punto_distribucion_id,cantidad,fecha_caducidad,ubicacion,estado,created_at\n";
            file_put_contents($csvPath, $header);
        }
    }

    private function obtenerProximoId() {
        $this->asegurarArchivo();
        $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
        
        $file = fopen($csvPath, 'r');
        $maxId = 0;
        
        while (($row = fgetcsv($file)) !== false) {
            if (is_numeric($row[0]) && $row[0] > $maxId) {
                $maxId = $row[0];
            }
        }
        fclose($file);
        
        return $maxId + 1;
    }

    public function guardar() {
        try {
            $this->asegurarArchivo();
            $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
            
            $this->id = $this->obtenerProximoId();
            $this->created_at = date('Y-m-d H:i:s');
            
            $file = fopen($csvPath, 'a');
            $row = [
                $this->id,
                $this->nombre_producto,
                $this->punto_distribucion_id,
                $this->cantidad,
                $this->fecha_caducidad,
                $this->ubicacion,
                $this->estado,
                $this->created_at
            ];
            fputcsv($file, $row);
            fclose($file);
            
            return $this->id;
        } catch (Throwable $exception) {
            throw new Exception("Error al guardar alerta de caducidad: " . $exception->getMessage());
        }
    }

    public static function listar() {
        try {
            $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
            
            if (!file_exists($csvPath)) {
                $header = "id,nombre_producto,punto_distribucion_id,cantidad,fecha_caducidad,ubicacion,estado,created_at\n";
                file_put_contents($csvPath, $header);
            }
            
            $alertas = [];
            $file = fopen($csvPath, 'r');
            
            $header = fgetcsv($file); // Skip header
            
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) >= 8 && !empty($row[0])) {
                    $alerta = new self(
                        $row[1], // nombre_producto
                        $row[2], // punto_distribucion_id
                        $row[3], // cantidad
                        $row[4], // fecha_caducidad
                        $row[5]  // ubicacion
                    );
                    $alerta->id = $row[0];
                    $alerta->estado = $row[6];
                    $alerta->created_at = $row[7];
                    $alertas[] = $alerta;
                }
            }
            fclose($file);
            
            // Ordenar por fecha de caducidad
            usort($alertas, function($a, $b) {
                return strtotime($a->fecha_caducidad) - strtotime($b->fecha_caducidad);
            });
            
            return $alertas;
        } catch (Throwable $exception) {
            throw new Exception("Error al listar alertas: " . $exception->getMessage());
        }
    }

    public static function obtenerPorId($id) {
        try {
            $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
            
            if (!file_exists($csvPath)) {
                return null;
            }
            
            $file = fopen($csvPath, 'r');
            $header = fgetcsv($file); // Skip header
            
            while (($row = fgetcsv($file)) !== false) {
                if ($row[0] == $id && count($row) >= 8) {
                    $alerta = new self(
                        $row[1],
                        $row[2],
                        $row[3],
                        $row[4],
                        $row[5]
                    );
                    $alerta->id = $row[0];
                    $alerta->estado = $row[6];
                    $alerta->created_at = $row[7];
                    fclose($file);
                    return $alerta;
                }
            }
            fclose($file);
            return null;
        } catch (Throwable $exception) {
            throw new Exception("Error al obtener alerta: " . $exception->getMessage());
        }
    }

    public static function eliminar($id) {
        try {
            $csvPath = __DIR__ . '/../../sql/alertas_caducidad.csv';
            
            if (!file_exists($csvPath)) {
                return false;
            }
            
            $file = fopen($csvPath, 'r');
            $tempFile = tempnam(sys_get_temp_dir(), 'csv_');
            $tempHandle = fopen($tempFile, 'w');
            
            $header = fgetcsv($file);
            fputcsv($tempHandle, $header);
            
            $encontrado = false;
            while (($row = fgetcsv($file)) !== false) {
                if ($row[0] != $id) {
                    fputcsv($tempHandle, $row);
                } else {
                    $encontrado = true;
                }
            }
            fclose($file);
            fclose($tempHandle);
            
            if ($encontrado) {
                rename($tempFile, $csvPath);
                return true;
            } else {
                unlink($tempFile);
                return false;
            }
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
}
?>
