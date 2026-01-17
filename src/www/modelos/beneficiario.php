<?php
/**
 * Modelo Beneficiario
 * Gestiona las operaciones relacionadas con beneficiarios
 */

require_once __DIR__ . '/bd.php';

class Beneficiario {
    private $id;
    private $nombre;
    private $apellidos;
    private $numero_identificacion;
    private $telefono;
    private $email;
    private $direccion;
    private $tamaño_familiar;
    private $necesidades;
    private $estado_validacion;
    private $fecha_ultima_asignacion;
    private $frecuencia_maxima_dias;
    private $created_at;
    private $updated_at;

    public function __construct($nombre = '', $apellidos = '', $numero_identificacion = '', $telefono = '', $email = '', $direccion = '', $tamaño_familiar = '', $necesidades = '') {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->numero_identificacion = $numero_identificacion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->tamaño_familiar = $tamaño_familiar;
        $this->necesidades = $necesidades;
        $this->estado_validacion = 'pendiente';
        $this->frecuencia_maxima_dias = 30;
    }

    /**
     * Guarda un nuevo beneficiario en la base de datos
     */
    public function guardar() {
        try {
            $bd = new BD();
            $sql = "INSERT INTO beneficiarios (nombre, apellidos, numero_identificacion, telefono, email, direccion, tamaño_familiar, necesidades, estado_validacion, frecuencia_maxima_dias) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $parametros = [
                $this->nombre,
                $this->apellidos,
                $this->numero_identificacion,
                $this->telefono,
                $this->email,
                $this->direccion,
                $this->tamaño_familiar,
                $this->necesidades,
                $this->estado_validacion,
                $this->frecuencia_maxima_dias
            ];

            $id = $bd->insertar($sql, $parametros);
            $this->id = $id;
            return $id;
        } catch (Exception $e) {
            throw new Exception("Error al guardar beneficiario: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un beneficiario existente
     */
    public function actualizar() {
        try {
            $bd = new BD();
            $sql = "UPDATE beneficiarios SET 
                    nombre = ?, 
                    apellidos = ?, 
                    numero_identificacion = ?, 
                    telefono = ?, 
                    email = ?, 
                    direccion = ?, 
                    tamaño_familiar = ?, 
                    necesidades = ?, 
                    estado_validacion = ?, 
                    frecuencia_maxima_dias = ? 
                    WHERE id = ?";
            
            $parametros = [
                $this->nombre,
                $this->apellidos,
                $this->numero_identificacion,
                $this->telefono,
                $this->email,
                $this->direccion,
                $this->tamaño_familiar,
                $this->necesidades,
                $this->estado_validacion,
                $this->frecuencia_maxima_dias,
                $this->id
            ];

            $bd->insertar($sql, $parametros);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar beneficiario: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todos los beneficiarios
     */
    public static function listar() {
        try {
            $bd = new BD();
            $sql = "SELECT * FROM beneficiarios ORDER BY nombre ASC";
            $resultados = $bd->seleccionar($sql);

            $beneficiarios = [];
            foreach ($resultados as $resultado) {
                $beneficiario = new Beneficiario();
                $beneficiario->id = $resultado['id'];
                $beneficiario->nombre = $resultado['nombre'];
                $beneficiario->apellidos = $resultado['apellidos'];
                $beneficiario->numero_identificacion = $resultado['numero_identificacion'];
                $beneficiario->telefono = $resultado['telefono'];
                $beneficiario->email = $resultado['email'];
                $beneficiario->direccion = $resultado['direccion'];
                $beneficiario->tamaño_familiar = $resultado['tamaño_familiar'];
                $beneficiario->necesidades = $resultado['necesidades'];
                $beneficiario->estado_validacion = $resultado['estado_validacion'];
                $beneficiario->fecha_ultima_asignacion = $resultado['fecha_ultima_asignacion'];
                $beneficiario->frecuencia_maxima_dias = $resultado['frecuencia_maxima_dias'];
                $beneficiario->created_at = $resultado['created_at'];
                $beneficiario->updated_at = $resultado['updated_at'];

                $beneficiarios[] = $beneficiario;
            }

            return $beneficiarios;
        } catch (Exception $e) {
            throw new Exception("Error al listar beneficiarios: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un beneficiario por ID
     */
    public static function obtenerPorId($id) {
        try {
            $bd = new BD();
            $sql = "SELECT * FROM beneficiarios WHERE id = ?";
            $resultados = $bd->seleccionar($sql, [$id]);

            if (empty($resultados)) {
                return null;
            }

            $resultado = $resultados[0];
            $beneficiario = new Beneficiario();
            $beneficiario->id = $resultado['id'];
            $beneficiario->nombre = $resultado['nombre'];
            $beneficiario->apellidos = $resultado['apellidos'];
            $beneficiario->numero_identificacion = $resultado['numero_identificacion'];
            $beneficiario->telefono = $resultado['telefono'];
            $beneficiario->email = $resultado['email'];
            $beneficiario->direccion = $resultado['direccion'];
            $beneficiario->tamaño_familiar = $resultado['tamaño_familiar'];
            $beneficiario->necesidades = $resultado['necesidades'];
            $beneficiario->estado_validacion = $resultado['estado_validacion'];
            $beneficiario->fecha_ultima_asignacion = $resultado['fecha_ultima_asignacion'];
            $beneficiario->frecuencia_maxima_dias = $resultado['frecuencia_maxima_dias'];
            $beneficiario->created_at = $resultado['created_at'];
            $beneficiario->updated_at = $resultado['updated_at'];

            return $beneficiario;
        } catch (Exception $e) {
            throw new Exception("Error al obtener beneficiario: " . $e->getMessage());
        }
    }

    /**
     * Busca beneficiarios por nombre, apellidos o número de identificación
     */
    public static function buscar($termino) {
        try {
            $bd = new BD();
            $sql = "SELECT * FROM beneficiarios WHERE 
                    nombre LIKE ? OR 
                    apellidos LIKE ? OR 
                    numero_identificacion LIKE ? 
                    ORDER BY nombre ASC";
            
            $termino_busqueda = '%' . $termino . '%';
            $resultados = $bd->seleccionar($sql, [$termino_busqueda, $termino_busqueda, $termino_busqueda]);

            $beneficiarios = [];
            foreach ($resultados as $resultado) {
                $beneficiario = new Beneficiario();
                $beneficiario->id = $resultado['id'];
                $beneficiario->nombre = $resultado['nombre'];
                $beneficiario->apellidos = $resultado['apellidos'];
                $beneficiario->numero_identificacion = $resultado['numero_identificacion'];
                $beneficiario->telefono = $resultado['telefono'];
                $beneficiario->email = $resultado['email'];
                $beneficiario->direccion = $resultado['direccion'];
                $beneficiario->tamaño_familiar = $resultado['tamaño_familiar'];
                $beneficiario->necesidades = $resultado['necesidades'];
                $beneficiario->estado_validacion = $resultado['estado_validacion'];
                $beneficiario->fecha_ultima_asignacion = $resultado['fecha_ultima_asignacion'];
                $beneficiario->frecuencia_maxima_dias = $resultado['frecuencia_maxima_dias'];
                $beneficiario->created_at = $resultado['created_at'];
                $beneficiario->updated_at = $resultado['updated_at'];

                $beneficiarios[] = $beneficiario;
            }

            return $beneficiarios;
        } catch (Exception $e) {
            throw new Exception("Error en búsqueda de beneficiarios: " . $e->getMessage());
        }
    }

    /**
     * Busca beneficiarios por estado de validación
     */
    public static function buscarPorEstado($estado) {
        try {
            $bd = new BD();
            $sql = "SELECT * FROM beneficiarios WHERE estado_validacion = ? ORDER BY nombre ASC";
            $resultados = $bd->seleccionar($sql, [$estado]);

            $beneficiarios = [];
            foreach ($resultados as $resultado) {
                $beneficiario = new Beneficiario();
                $beneficiario->id = $resultado['id'];
                $beneficiario->nombre = $resultado['nombre'];
                $beneficiario->apellidos = $resultado['apellidos'];
                $beneficiario->numero_identificacion = $resultado['numero_identificacion'];
                $beneficiario->telefono = $resultado['telefono'];
                $beneficiario->email = $resultado['email'];
                $beneficiario->direccion = $resultado['direccion'];
                $beneficiario->tamaño_familiar = $resultado['tamaño_familiar'];
                $beneficiario->necesidades = $resultado['necesidades'];
                $beneficiario->estado_validacion = $resultado['estado_validacion'];
                $beneficiario->fecha_ultima_asignacion = $resultado['fecha_ultima_asignacion'];
                $beneficiario->frecuencia_maxima_dias = $resultado['frecuencia_maxima_dias'];
                $beneficiario->created_at = $resultado['created_at'];
                $beneficiario->updated_at = $resultado['updated_at'];

                $beneficiarios[] = $beneficiario;
            }

            return $beneficiarios;
        } catch (Exception $e) {
            throw new Exception("Error al buscar beneficiarios por estado: " . $e->getMessage());
        }
    }

    /**
     * Obtiene el historial de asignaciones de un beneficiario
     */
    public function obtenerHistorialAsignaciones() {
        try {
            $bd = new BD();
            $sql = "SELECT ap.*, pd.nombre as punto_distribucion_nombre 
                    FROM asignaciones_productos ap
                    LEFT JOIN puntos_distribucion pd ON ap.punto_distribucion_id = pd.id
                    WHERE ap.beneficiario_id = ?
                    ORDER BY ap.fecha_asignacion DESC";
            
            return $bd->seleccionar($sql, [$this->id]);
        } catch (Exception $e) {
            throw new Exception("Error al obtener historial: " . $e->getMessage());
        }
    }

    /**
     * Verifica si puede recibir nueva asignación según frecuencia
     */
    public function puedeRecibirAsignacion() {
        if ($this->fecha_ultima_asignacion == null) {
            return true;
        }

        $fecha_ultima = new DateTime($this->fecha_ultima_asignacion);
        $fecha_actual = new DateTime();
        // Permitir asignaciones múltiples el mismo día
        if ($fecha_ultima->format('Y-m-d') === $fecha_actual->format('Y-m-d')) {
            return true;
        }

        $diferencia = $fecha_actual->diff($fecha_ultima)->days;
        return $diferencia >= $this->frecuencia_maxima_dias;
    }

    /**
     * Registra una asignación de producto para este beneficiario
     */
    public function asignarProducto($nombre_producto, $cantidad, $punto_distribucion_id, $coordinador, $notas = '') {
        try {
            $bd = new BD();
            
            // Verificar si puede recibir asignación
            if (!$this->puedeRecibirAsignacion()) {
                throw new Exception("El beneficiario no puede recibir asignaciones tan frecuentemente");
            }

            $sql = "INSERT INTO asignaciones_productos 
                    (beneficiario_id, nombre_producto, cantidad, punto_distribucion_id, coordinador, notas) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $id_asignacion = $bd->insertar($sql, [
                $this->id,
                $nombre_producto,
                $cantidad,
                $punto_distribucion_id,
                $coordinador,
                $notas
            ]);

            // Actualizar fecha de última asignación
            $sql_actualizar = "UPDATE beneficiarios SET fecha_ultima_asignacion = NOW() WHERE id = ?";
            $bd->insertar($sql_actualizar, [$this->id]);

            $this->fecha_ultima_asignacion = date('Y-m-d H:i:s');

            return $id_asignacion;
        } catch (Exception $e) {
            throw new Exception("Error al asignar producto: " . $e->getMessage());
        }
    }

    /**
     * Elimina un beneficiario (y sus asignaciones por FK ON DELETE CASCADE)
     */
    public static function eliminar($id) {
        try {
            $bd = new BD();
            $sql = "DELETE FROM beneficiarios WHERE id = ?";
            return $bd->ejecutar($sql, [$id]);
        } catch (Exception $e) {
            throw new Exception("Error al eliminar beneficiario: " . $e->getMessage());
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getApellidos() { return $this->apellidos; }
    public function getNumeroIdentificacion() { return $this->numero_identificacion; }
    public function getTelefono() { return $this->telefono; }
    public function getEmail() { return $this->email; }
    public function getDireccion() { return $this->direccion; }
    public function getTamañoFamiliar() { return $this->tamaño_familiar; }
    public function getNecesidades() { return $this->necesidades; }
    public function getEstadoValidacion() { return $this->estado_validacion; }
    public function getFechaUltimaAsignacion() { return $this->fecha_ultima_asignacion; }
    public function getFrecuenciaMaximaDias() { return $this->frecuencia_maxima_dias; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setters
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellidos($apellidos) { $this->apellidos = $apellidos; }
    public function setNumeroIdentificacion($numero) { $this->numero_identificacion = $numero; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setEmail($email) { $this->email = $email; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setTamañoFamiliar($tamaño) { $this->tamaño_familiar = $tamaño; }
    public function setNecesidades($necesidades) { $this->necesidades = $necesidades; }
    public function setEstadoValidacion($estado) { $this->estado_validacion = $estado; }
    public function setFrecuenciaMaximaDias($dias) { $this->frecuencia_maxima_dias = $dias; }
}
?>
