<?php
/**
 * Modelo PuntoDistribucion
 */
require_once __DIR__ . '/bd.php';

class PuntoDistribucion {
    private $id;
    private $nombre;
    private $direccion;
    private $responsable;
    private $telefono;
    private $latitud;
    private $longitud;
    private $horario;
    private $descripcion;
    private $created_at;

    public function __construct($nombre, $direccion, $responsable, $telefono, $latitud, $longitud, $horario, $descripcion = null) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->responsable = $responsable;
        $this->telefono = $telefono;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->horario = $horario;
        $this->descripcion = $descripcion;
    }

    private static function asegurarTabla(BD $bd) {
        $sql = "CREATE TABLE IF NOT EXISTS puntos_distribucion (\n            id INT(11) NOT NULL AUTO_INCREMENT,\n            nombre VARCHAR(255) NOT NULL,\n            direccion TEXT NOT NULL,\n            responsable VARCHAR(255) NOT NULL,\n            telefono VARCHAR(50) NOT NULL,\n            latitud DECIMAL(10,6) DEFAULT NULL,\n            longitud DECIMAL(10,6) DEFAULT NULL,\n            horario VARCHAR(255) DEFAULT NULL,\n            descripcion TEXT DEFAULT NULL,\n            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n            PRIMARY KEY (id)\n        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        $bd->seleccionar($sql);
    }

    public function guardar() {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);

            $sql = "INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) \n                    VALUES (:nombre, :direccion, :responsable, :telefono, :latitud, :longitud, :horario, :descripcion, NOW())";
            $params = [
                ':nombre' => $this->nombre,
                ':direccion' => $this->direccion,
                ':responsable' => $this->responsable,
                ':telefono' => $this->telefono,
                ':latitud' => $this->latitud !== '' ? $this->latitud : null,
                ':longitud' => $this->longitud !== '' ? $this->longitud : null,
                ':horario' => $this->horario,
                ':descripcion' => $this->descripcion
            ];
            $this->id = $bd->insertar($sql, $params);
            $this->created_at = date('Y-m-d H:i:s');

            return $this->id;
        } catch (Throwable $exception) {
            throw new Exception("Error al guardar punto de distribución: " . $exception->getMessage());
        }
    }

    public static function listar() {
        try {
            $bd = new BD();
            self::asegurarTabla($bd);
            $sql = "SELECT * FROM puntos_distribucion ORDER BY created_at DESC, id DESC";
            $filas = $bd->seleccionar($sql);
            $lista = [];
            foreach ($filas as $fila) {
                $punto = new PuntoDistribucion(
                    $fila['nombre'],
                    $fila['direccion'],
                    $fila['responsable'],
                    $fila['telefono'],
                    $fila['latitud'],
                    $fila['longitud'],
                    $fila['horario'],
                    $fila['descripcion']
                );
                $punto->id = $fila['id'];
                $punto->created_at = $fila['created_at'];
                $lista[] = $punto;
            }
            return $lista;
        } catch (Throwable $exception) {
            // Si falla la BD, intentar cargar desde el volcado SQL
            return self::listarDesdeDump();
        }
    }

    private static function listarDesdeDump() {
        $dumpPath = __DIR__ . '/../../sql/sprint.sql';
        if (!file_exists($dumpPath)) {
            return [];
        }
        $contenido = file_get_contents($dumpPath);
        if ($contenido === false) {
            return [];
        }

        $puntos = [];
        if (preg_match_all('/INSERT INTO\s+puntos_distribucion\s*\([^)]*\)\s*VALUES\s*\(([^;]+?)\);/i', $contenido, $matches)) {
            foreach ($matches[1] as $valuesList) {
                $values = self::parsearValores($valuesList);
                if (count($values) >= 9) {
                    $punto = new PuntoDistribucion(
                        $values[0],
                        $values[1],
                        $values[2],
                        $values[3],
                        $values[4],
                        $values[5],
                        $values[6],
                        $values[7] === null ? null : $values[7]
                    );
                    $punto->created_at = $values[8];
                    $puntos[] = $punto;
                }
            }
        }
        return $puntos;
    }

    private static function parsearValores($valuesList) {
        $values = [];
        $len = strlen($valuesList);
        $cur = '';
        $inQuote = false;
        for ($i = 0; $i < $len; $i++) {
            $ch = $valuesList[$i];
            if ($ch === "'") {
                $inQuote = !$inQuote;
                $cur .= $ch;
                continue;
            }
            if ($ch === ',' && !$inQuote) {
                $values[] = trim($cur);
                $cur = '';
                continue;
            }
            $cur .= $ch;
        }
        if (strlen(trim($cur)) > 0) {
            $values[] = trim($cur);
        }

        return array_map(function($v) {
            $v = trim($v);
            if (strtoupper($v) === 'NULL') return null;
            if (strlen($v) >= 2 && $v[0] === "'" && $v[strlen($v) - 1] === "'") {
                return str_replace("\\'", "'", substr($v, 1, -1));
            }
            return $v;
        }, $values);
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDireccion() { return $this->direccion; }
    public function getResponsable() { return $this->responsable; }
    public function getTelefono() { return $this->telefono; }
    public function getLatitud() { return $this->latitud; }
    public function getLongitud() { return $this->longitud; }
    public function getHorario() { return $this->horario; }
    public function getDescripcion() { return $this->descripcion; }
    public function getCreatedAt() { return $this->created_at; }
}
?>
