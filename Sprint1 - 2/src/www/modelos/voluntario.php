<?php
/**
 * Modelo Voluntario - Versión robusta
 */
// Cargar dependencia de la BD localmente (evita depender del autoloader para nombres en minúscula)
require_once __DIR__ . '/bd.php';
class Voluntario {
    private $id;
    private $nombre;
    private $telefono;
    private $horas_disponibles;
    private $habilidades;
    private $fecha_creacion;

    public function __construct($nombre, $telefono, $horas_disponibles, $habilidades) {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->horas_disponibles = $horas_disponibles;
        $this->habilidades = $habilidades;
    }

    public function guardar() {
        try {
            // Guardar en el volcado SQL (archivo) en lugar de la base de datos
            $destDir = __DIR__ . '/../../sql';
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            $filePath = $destDir . '/sprint.sql';

            // Normalizar y escapar valores para insertar en el archivo SQL
            $nombre = addslashes(trim($this->nombre));
            $telefono = addslashes(trim($this->telefono));
            $horas = (int) $this->horas_disponibles;
            $habilidades = is_null($this->habilidades) ? null : addslashes(trim($this->habilidades));

            // Construir la sentencia INSERT (omitimos id para que la importación en MySQL lo genere)
            $cols = ['nombre', 'telefono', 'horas_disponibles', 'habilidades', 'fecha_creacion'];
            $fecha = date('Y-m-d H:i:s');
            $valores = [];
            $valores[] = "'{$nombre}'";
            $valores[] = "'{$telefono}'";
            $valores[] = (int) $horas;
            $valores[] = is_null($habilidades) ? 'NULL' : "'{$habilidades}'";
            $valores[] = "'{$fecha}'";

            $insertSql = "INSERT INTO voluntarios_db (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $valores) . ");" . PHP_EOL;

            // Añadir al archivo (append)
            $ok = file_put_contents($filePath, $insertSql, FILE_APPEND | LOCK_EX);
            if ($ok === false) {
                throw new Exception("No se pudo escribir en el archivo de volcado: $filePath");
            }

            // Devolver un identificador simbólico (timestamp) para la UI
            $this->id = time();
            return $this->id;

        } catch (Exception $exception) {
            throw new Exception("Error al guardar voluntario.php: " . $exception->getMessage());
        }
    }

    public static function listar() {
        try {
            $bd = new BD();
            
            // Determinar la columna de ordenación
            $columnas = $bd->seleccionar("SHOW COLUMNS FROM voluntarios_db");
            $columnas_existentes = array_column($columnas, 'Field');
            
            $order_column = 'id'; // Por defecto
            if (in_array('fecha_creacion', $columnas_existentes)) {
                $order_column = 'fecha_creacion';
            } elseif (in_array('fecha', $columnas_existentes)) {
                $order_column = 'fecha';
            } elseif (in_array('created_at', $columnas_existentes)) {
                $order_column = 'created_at';
            }
            
            $sql = "SELECT * FROM voluntarios_db ORDER BY $order_column DESC";
            $resultados = $bd->seleccionar($sql);
            
            $voluntarios = [];
            // Marcar claves vistas (para evitar duplicados al mezclar DB + archivo)
            $vistas_keys = [];
            foreach ($resultados as $fila) {
                $voluntario = new Voluntario(
                    $fila['nombre'],
                    $fila['telefono'],
                    $fila['horas_disponibles'],
                    $fila['habilidades']
                );
                $voluntario->id = $fila['id'];
                
                // Asignar fecha de creación
                foreach (['fecha_creacion', 'fecha', 'created_at'] as $columna_fecha) {
                    if (isset($fila[$columna_fecha])) {
                        $voluntario->fecha_creacion = $fila[$columna_fecha];
                        break;
                    }
                }
                
                // Si no se encontró columna de fecha, usar fecha actual
                if (empty($voluntario->fecha_creacion)) {
                    $voluntario->fecha_creacion = date('Y-m-d H:i:s');
                }
                
                $voluntarios[] = $voluntario;
                // clave única simple: nombre|telefono|fecha
                $key = trim($fila['nombre']) . '|' . trim($fila['telefono']) . '|' . (isset($fila['fecha_creacion']) ? $fila['fecha_creacion'] : '');
                $vistas_keys[$key] = true;
            }

            // Además, cargar inserciones que estén en el volcado SQL (sprint.sql) y no estén en la BD
            $dumpPath = __DIR__ . '/../../sql/sprint.sql';
            if (file_exists($dumpPath)) {
                $contents = file_get_contents($dumpPath);
                if ($contents !== false) {
                    // Buscar todas las sentencias INSERT INTO voluntarios_db (... ) VALUES (...);
                    if (preg_match_all('/INSERT INTO\s+voluntarios_db\s*\([^)]*\)\s*VALUES\s*\(([^;]+?)\);/i', $contents, $matches)) {
                        foreach ($matches[1] as $valuesList) {
                            // Parsear valores respetando comillas simples
                            $values = [];
                            $len = strlen($valuesList);
                            $cur = '';
                            $inQuote = false;
                            for ($i = 0; $i < $len; $i++) {
                                $ch = $valuesList[$i];
                                if ($ch === "'") {
                                    // comprobar escape '\\'' (backslash)
                                    $prev = ($i > 0) ? $valuesList[$i-1] : '';
                                    if ($inQuote && $prev === "\\\\") {
                                        // parte de una comilla escapada, mantener
                                        $cur .= $ch;
                                        continue;
                                    }
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
                            if (strlen(trim($cur)) > 0) $values[] = trim($cur);

                            // Limpiar comillas de cadenas y NULLs
                            $clean = array_map(function($v) {
                                $v = trim($v);
                                if (strtoupper($v) === 'NULL') return null;
                                // quitar comillas simples envolventes
                                if (strlen($v) >= 2 && $v[0] === "'" && $v[strlen($v)-1] === "'") {
                                    $inner = substr($v, 1, -1);
                                    // deshacer escapes simples
                                    $inner = str_replace("\\'", "'", $inner);
                                    $inner = str_replace('\\\\', '\\', $inner);
                                    return $inner;
                                }
                                return $v;
                            }, $values);

                            // Esperamos columnas: nombre, telefono, horas_disponibles, habilidades, fecha_creacion
                            if (count($clean) >= 4) {
                                $nombre = $clean[0];
                                $telefono = $clean[1];
                                $horas = isset($clean[2]) ? (int)$clean[2] : 0;
                                $habilidades = isset($clean[3]) ? $clean[3] : null;
                                $fecha_creacion = isset($clean[4]) ? $clean[4] : date('Y-m-d H:i:s');

                                $key = trim($nombre) . '|' . trim($telefono) . '|' . $fecha_creacion;
                                if (!isset($vistas_keys[$key])) {
                                    $vol = new Voluntario($nombre, $telefono, $horas, $habilidades);
                                    $vol->fecha_creacion = $fecha_creacion;
                                    $voluntarios[] = $vol;
                                    $vistas_keys[$key] = true;
                                }
                            }
                        }
                    }
                }
            }
            
            return $voluntarios;
            
        } catch (Exception $exception) {
            throw new Exception("Error al listar voluntarios: " . $exception->getMessage());
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getTelefono() { return $this->telefono; }
    public function getHorasDisponibles() { return $this->horas_disponibles; }
    public function getHabilidades() { return $this->habilidades; }
    public function getFechaCreacion() { return $this->fecha_creacion; }
}
?>