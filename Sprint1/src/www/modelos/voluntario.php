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
            $bd = new BD();
            
            // Determinar qué columnas existen
            $columnas = $bd->seleccionar("SHOW COLUMNS FROM voluntarios_db");
            $columnas_existentes = array_column($columnas, 'Field');
            
            // Construir SQL dinámicamente
            if (in_array('fecha_creacion', $columnas_existentes)) {
                $sql = "INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades, fecha_creacion) 
                        VALUES (:nombre, :telefono, :horas, :habilidades, NOW())";
            } else {
                $sql = "INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades) 
                        VALUES (:nombre, :telefono, :horas, :habilidades)";
            }
            
            // Usar claves sin ':' es la forma recomendada al pasar parámetros a PDO::execute
            $parametros = [
                'nombre' => $this->nombre,
                'telefono' => $this->telefono,
                'horas' => $this->horas_disponibles,
                'habilidades' => $this->habilidades
            ];
            
            $this->id = $bd->insertar($sql, $parametros);
            return $this->id;
            
        } catch (Exception $exception) {
            throw new Exception("Error al guardar voluntario: " . $exception->getMessage());
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