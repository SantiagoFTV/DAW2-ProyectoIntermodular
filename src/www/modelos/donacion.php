<?php
/**
 * Modelo Donacion
 * Gestiona las operaciones relacionadas con el registro de donaciones entrantes
 * HU-01: Registro de Donaciones Entrantes
 */

require_once __DIR__ . '/bd.php';

class Donacion {
    private $id;
    private $nombre_donante;
    private $tipo_producto;
    private $cantidad;
    private $unidad_medida;
    private $fecha_recepcion;
    private $fecha_caducidad;
    private $punto_distribucion_id;
    private $observaciones;
    private $estado;
    private $created_at;
    private $updated_at;

    public function __construct($nombre_donante = '', $tipo_producto = '', $cantidad = 0, $unidad_medida = 'unidades', $fecha_recepcion = '', $fecha_caducidad = null, $punto_distribucion_id = null, $observaciones = '') {
        $this->nombre_donante = $nombre_donante;
        $this->tipo_producto = $tipo_producto;
        $this->cantidad = $cantidad;
        $this->unidad_medida = $unidad_medida;
        $this->fecha_recepcion = $fecha_recepcion;
        $this->fecha_caducidad = $fecha_caducidad;
        $this->punto_distribucion_id = $punto_distribucion_id;
        $this->observaciones = $observaciones;
        $this->estado = 'recibido';
    }

    /**
     * Guarda una nueva donación en la base de datos
     */
    public function guardar() {
        try {
            $bd = new BD();
            $sql = "INSERT INTO donaciones (nombre_donante, tipo_producto, cantidad, unidad_medida, fecha_recepcion, fecha_caducidad, punto_distribucion_id, observaciones, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $parametros = [
                $this->nombre_donante,
                $this->tipo_producto,
                $this->cantidad,
                $this->unidad_medida,
                $this->fecha_recepcion,
                $this->fecha_caducidad,
                $this->punto_distribucion_id,
                $this->observaciones,
                $this->estado
            ];

            $id = $bd->insertar($sql, $parametros);
            $this->id = $id;
            
            // Si la donación tiene fecha de caducidad, crear una alerta automáticamente
            if ($this->fecha_caducidad && $this->punto_distribucion_id) {
                try {
                    require_once __DIR__ . '/alertaCaducidad.php';
                    $alerta = new AlertaCaducidad(
                        $this->tipo_producto,
                        $this->punto_distribucion_id,
                        $this->cantidad,
                        $this->fecha_caducidad,
                        'Donación: ' . $this->nombre_donante
                    );
                    $alerta->guardar();
                } catch (Exception $e) {
                    // Si falla la creación de alerta, no fallar la donación
                    error_log("Advertencia: No se pudo crear alerta de caducidad para donación ID $id: " . $e->getMessage());
                }
            }
            
            return $id;
        } catch (Exception $e) {
            throw new Exception("Error al guardar donación: " . $e->getMessage());
        }
    }

    /**
     * Actualiza una donación existente
     */
    public function actualizar() {
        try {
            $bd = new BD();
            $sql = "UPDATE donaciones SET 
                    nombre_donante = ?, 
                    tipo_producto = ?, 
                    cantidad = ?, 
                    unidad_medida = ?,
                    fecha_recepcion = ?, 
                    fecha_caducidad = ?, 
                    punto_distribucion_id = ?, 
                    observaciones = ?, 
                    estado = ?
                    WHERE id = ?";
            
            $parametros = [
                $this->nombre_donante,
                $this->tipo_producto,
                $this->cantidad,
                $this->unidad_medida,
                $this->fecha_recepcion,
                $this->fecha_caducidad,
                $this->punto_distribucion_id,
                $this->observaciones,
                $this->estado,
                $this->id
            ];

            $resultado = $bd->actualizar($sql, $parametros);
            
            // Actualizar alerta de caducidad si aplica
            if ($this->fecha_caducidad && $this->punto_distribucion_id) {
                try {
                    require_once __DIR__ . '/alertaCaducidad.php';
                    // Buscar si existe una alerta para esta donación
                    $sqlBuscar = "SELECT id FROM alertas_caducidad 
                                 WHERE nombre_producto = ? 
                                 AND punto_distribucion_id = ? 
                                 AND fecha_caducidad = ?
                                 AND ubicacion LIKE ?
                                 LIMIT 1";
                    $resultados = $bd->seleccionar($sqlBuscar, [
                        $this->tipo_producto,
                        $this->punto_distribucion_id,
                        $this->fecha_caducidad,
                        'Donación: ' . $this->nombre_donante
                    ]);
                    
                    if (count($resultados) > 0) {
                        // Actualizar alerta existente
                        $sqlUpdate = "UPDATE alertas_caducidad SET 
                                     cantidad = ?, 
                                     nombre_producto = ?,
                                     estado = ?
                                     WHERE id = ?";
                        // Determinar estado
                        $alerta = new AlertaCaducidad(
                            $this->tipo_producto,
                            $this->punto_distribucion_id,
                            $this->cantidad,
                            $this->fecha_caducidad,
                            'Donación: ' . $this->nombre_donante
                        );
                        $bd->actualizar($sqlUpdate, [
                            $this->cantidad,
                            $this->tipo_producto,
                            $alerta->getEstado(),
                            $resultados[0]['id']
                        ]);
                    }
                } catch (Exception $e) {
                    error_log("Advertencia: No se pudo actualizar alerta de caducidad para donación ID " . $this->id . ": " . $e->getMessage());
                }
            }
            
            return $resultado;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar donación: " . $e->getMessage());
        }
    }

    /**
     * Lista todas las donaciones
     */
    public static function listar() {
        try {
            $bd = new BD();
            $sql = "SELECT d.*, p.nombre as nombre_punto_distribucion 
                    FROM donaciones d 
                    LEFT JOIN puntos_distribucion p ON d.punto_distribucion_id = p.id 
                    ORDER BY d.created_at DESC";
            
            $resultados = $bd->seleccionar($sql);
            
            $donaciones = [];
            foreach ($resultados as $fila) {
                $donacion = new Donacion();
                $donacion->cargarDesdeFila($fila);
                $donaciones[] = $donacion;
            }
            
            return $donaciones;
        } catch (Exception $e) {
            throw new Exception("Error al listar donaciones: " . $e->getMessage());
        }
    }

    /**
     * Busca donaciones por término
     */
    public static function buscar($termino) {
        try {
            $bd = new BD();
            $sql = "SELECT d.*, p.nombre as nombre_punto_distribucion 
                    FROM donaciones d 
                    LEFT JOIN puntos_distribucion p ON d.punto_distribucion_id = p.id 
                    WHERE d.nombre_donante LIKE ? 
                    OR d.tipo_producto LIKE ? 
                    OR d.observaciones LIKE ?
                    ORDER BY d.created_at DESC";
            
            $terminoBusqueda = "%$termino%";
            $parametros = [$terminoBusqueda, $terminoBusqueda, $terminoBusqueda];
            
            $resultados = $bd->seleccionar($sql, $parametros);
            
            $donaciones = [];
            foreach ($resultados as $fila) {
                $donacion = new Donacion();
                $donacion->cargarDesdeFila($fila);
                $donaciones[] = $donacion;
            }
            
            return $donaciones;
        } catch (Exception $e) {
            throw new Exception("Error al buscar donaciones: " . $e->getMessage());
        }
    }

    /**
     * Filtra donaciones por criterios
     */
    public static function filtrar($fecha_desde = null, $fecha_hasta = null, $donante = '', $tipo_producto = '') {
        try {
            $bd = new BD();
            $where = [];
            $parametros = [];

            if ($fecha_desde) {
                $where[] = "d.fecha_recepcion >= ?";
                $parametros[] = $fecha_desde;
            }

            if ($fecha_hasta) {
                $where[] = "d.fecha_recepcion <= ?";
                $parametros[] = $fecha_hasta;
            }

            if ($donante) {
                $where[] = "d.nombre_donante LIKE ?";
                $parametros[] = "%$donante%";
            }

            if ($tipo_producto) {
                $where[] = "d.tipo_producto LIKE ?";
                $parametros[] = "%$tipo_producto%";
            }

            $whereClause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

            $sql = "SELECT d.*, p.nombre as nombre_punto_distribucion 
                    FROM donaciones d 
                    LEFT JOIN puntos_distribucion p ON d.punto_distribucion_id = p.id 
                    $whereClause
                    ORDER BY d.created_at DESC";
            
            $resultados = $bd->seleccionar($sql, $parametros);
            
            $donaciones = [];
            foreach ($resultados as $fila) {
                $donacion = new Donacion();
                $donacion->cargarDesdeFila($fila);
                $donaciones[] = $donacion;
            }
            
            return $donaciones;
        } catch (Exception $e) {
            throw new Exception("Error al filtrar donaciones: " . $e->getMessage());
        }
    }

    /**
     * Obtiene una donación por ID
     */
    public static function obtenerPorId($id) {
        try {
            $bd = new BD();
            $sql = "SELECT d.*, p.nombre as nombre_punto_distribucion 
                    FROM donaciones d 
                    LEFT JOIN puntos_distribucion p ON d.punto_distribucion_id = p.id 
                    WHERE d.id = ?";
            
            $resultados = $bd->seleccionar($sql, [$id]);
            
            if (count($resultados) === 0) {
                return null;
            }
            
            $donacion = new Donacion();
            $donacion->cargarDesdeFila($resultados[0]);
            
            return $donacion;
        } catch (Exception $e) {
            throw new Exception("Error al obtener donación: " . $e->getMessage());
        }
    }

    /**
     * Elimina una donación
     */
    public static function eliminar($id) {
        try {
            $bd = new BD();
            
            // Obtener datos de la donación antes de eliminar
            $sqlBuscar = "SELECT tipo_producto, punto_distribucion_id, nombre_donante, fecha_caducidad FROM donaciones WHERE id = ?";
            $resultados = $bd->seleccionar($sqlBuscar, [$id]);
            
            if (count($resultados) > 0) {
                $donacion = $resultados[0];
                
                // Eliminar alertas asociadas si existen
                try {
                    $sqlEliminar = "DELETE FROM alertas_caducidad 
                                   WHERE nombre_producto = ? 
                                   AND punto_distribucion_id = ? 
                                   AND fecha_caducidad = ?
                                   AND ubicacion LIKE ?";
                    $bd->eliminar($sqlEliminar, [
                        $donacion['tipo_producto'],
                        $donacion['punto_distribucion_id'],
                        $donacion['fecha_caducidad'],
                        'Donación: ' . $donacion['nombre_donante']
                    ]);
                } catch (Exception $e) {
                    error_log("Advertencia: No se pudo eliminar alertas asociadas a donación ID $id: " . $e->getMessage());
                }
            }
            
            // Eliminar donación
            $sql = "DELETE FROM donaciones WHERE id = ?";
            return $bd->eliminar($sql, [$id]);
        } catch (Exception $e) {
            throw new Exception("Error al eliminar donación: " . $e->getMessage());
        }
    }

    /**
     * Obtiene estadísticas de donaciones
     */
    public static function obtenerEstadisticas() {
        try {
            $bd = new BD();
            
            // Total de donaciones
            $sql = "SELECT COUNT(*) as total FROM donaciones";
            $resultado = $bd->seleccionar($sql);
            $total = $resultado[0]['total'];

            // Total de cantidad
            $sql = "SELECT SUM(cantidad) as total_cantidad FROM donaciones";
            $resultado = $bd->seleccionar($sql);
            $total_cantidad = $resultado[0]['total_cantidad'] ?? 0;

            // Donaciones del mes actual
            $sql = "SELECT COUNT(*) as este_mes FROM donaciones WHERE MONTH(fecha_recepcion) = MONTH(CURDATE()) AND YEAR(fecha_recepcion) = YEAR(CURDATE())";
            $resultado = $bd->seleccionar($sql);
            $este_mes = $resultado[0]['este_mes'];

            // Tipos de productos únicos
            $sql = "SELECT COUNT(DISTINCT tipo_producto) as tipos_productos FROM donaciones";
            $resultado = $bd->seleccionar($sql);
            $tipos_productos = $resultado[0]['tipos_productos'];

            return [
                'total' => $total,
                'total_cantidad' => $total_cantidad,
                'este_mes' => $este_mes,
                'tipos_productos' => $tipos_productos
            ];
        } catch (Exception $e) {
            throw new Exception("Error al obtener estadísticas: " . $e->getMessage());
        }
    }

    /**
     * Carga los datos desde una fila de la base de datos
     */
    private function cargarDesdeFila($fila) {
        $this->id = $fila['id'];
        $this->nombre_donante = $fila['nombre_donante'];
        $this->tipo_producto = $fila['tipo_producto'];
        $this->cantidad = $fila['cantidad'];
        $this->unidad_medida = $fila['unidad_medida'];
        $this->fecha_recepcion = $fila['fecha_recepcion'];
        $this->fecha_caducidad = $fila['fecha_caducidad'];
        $this->punto_distribucion_id = $fila['punto_distribucion_id'];
        $this->observaciones = $fila['observaciones'];
        $this->estado = $fila['estado'];
        $this->created_at = $fila['created_at'];
        $this->updated_at = $fila['updated_at'];
        
        if (isset($fila['nombre_punto_distribucion'])) {
            $this->nombre_punto_distribucion = $fila['nombre_punto_distribucion'];
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombreDonante() { return $this->nombre_donante; }
    public function getTipoProducto() { return $this->tipo_producto; }
    public function getCantidad() { return $this->cantidad; }
    public function getUnidadMedida() { return $this->unidad_medida; }
    public function getFechaRecepcion() { return $this->fecha_recepcion; }
    public function getFechaCaducidad() { return $this->fecha_caducidad; }
    public function getPuntoDistribucionId() { return $this->punto_distribucion_id; }
    public function getObservaciones() { return $this->observaciones; }
    public function getEstado() { return $this->estado; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    public function getNombrePuntoDistribucion() { return $this->nombre_punto_distribucion ?? 'Sin asignar'; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombreDonante($nombre_donante) { $this->nombre_donante = $nombre_donante; }
    public function setTipoProducto($tipo_producto) { $this->tipo_producto = $tipo_producto; }
    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }
    public function setUnidadMedida($unidad_medida) { $this->unidad_medida = $unidad_medida; }
    public function setFechaRecepcion($fecha_recepcion) { $this->fecha_recepcion = $fecha_recepcion; }
    public function setFechaCaducidad($fecha_caducidad) { $this->fecha_caducidad = $fecha_caducidad; }
    public function setPuntoDistribucionId($punto_distribucion_id) { $this->punto_distribucion_id = $punto_distribucion_id; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }
    public function setEstado($estado) { $this->estado = $estado; }
}
?>
