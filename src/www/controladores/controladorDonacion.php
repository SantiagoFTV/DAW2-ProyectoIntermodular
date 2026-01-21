<?php
/**
 * Controlador de Donaciones
 * Gestiona la lógica de la HU-01: Registro de Donaciones Entrantes
 * SOLO ACCESIBLE POR ADMINISTRADORES
 */

class ControladorDonacion {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Lista todas las donaciones (solo admin)
     */
    public function listar() {
        try {
            // Verificar que sea administrador
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            require_once($this->config['dir_modelos'] . 'donacion.php');
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            
            $donaciones = Donacion::listar();
            $estadisticas = Donacion::obtenerEstadisticas();
            $puntos_distribucion = PuntoDistribucion::listar();

            $donaciones_vista = $donaciones;
            $estadisticas_vista = $estadisticas;
            $puntos_distribucion_vista = $puntos_distribucion;
            $config = $this->config;

            require_once($this->config['dir_vistas'] . 'gestion_donaciones.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Busca donaciones por término (solo admin)
     */
    public function buscar() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $termino = isset($_POST['termino_busqueda']) ? trim($_POST['termino_busqueda']) : '';

            if (empty($termino)) {
                $this->listar();
                return;
            }

            require_once($this->config['dir_modelos'] . 'donacion.php');
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            
            $donaciones = Donacion::buscar($termino);
            $estadisticas = Donacion::obtenerEstadisticas();
            $puntos_distribucion = PuntoDistribucion::listar();

            $donaciones_vista = $donaciones;
            $estadisticas_vista = $estadisticas;
            $puntos_distribucion_vista = $puntos_distribucion;
            $termino_busqueda = $termino;
            $config = $this->config;

            require_once($this->config['dir_vistas'] . 'gestion_donaciones.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Filtra donaciones por criterios (solo admin)
     */
    public function filtrar() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $fecha_desde = isset($_POST['fecha_desde']) ? trim($_POST['fecha_desde']) : null;
            $fecha_hasta = isset($_POST['fecha_hasta']) ? trim($_POST['fecha_hasta']) : null;
            $donante = isset($_POST['donante']) ? trim($_POST['donante']) : '';
            $tipo_producto = isset($_POST['tipo_producto']) ? trim($_POST['tipo_producto']) : '';

            require_once($this->config['dir_modelos'] . 'donacion.php');
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            
            $donaciones = Donacion::filtrar($fecha_desde, $fecha_hasta, $donante, $tipo_producto);
            $estadisticas = Donacion::obtenerEstadisticas();
            $puntos_distribucion = PuntoDistribucion::listar();

            $donaciones_vista = $donaciones;
            $estadisticas_vista = $estadisticas;
            $puntos_distribucion_vista = $puntos_distribucion;
            $config = $this->config;

            // Mantener valores del filtro
            $filtro_fecha_desde = $fecha_desde;
            $filtro_fecha_hasta = $fecha_hasta;
            $filtro_donante = $donante;
            $filtro_tipo_producto = $tipo_producto;

            require_once($this->config['dir_vistas'] . 'gestion_donaciones.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Crea una nueva donación (solo admin)
     */
    public function crear() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?controlador=Donacion&metodo=listar');
                exit;
            }

            // Validar campos obligatorios
            $errores = [];
            
            $nombre_donante = isset($_POST['nombre_donante']) ? trim($_POST['nombre_donante']) : '';
            if (empty($nombre_donante)) {
                $errores[] = "El nombre del donante es obligatorio";
            }

            $tipo_producto = isset($_POST['tipo_producto']) ? trim($_POST['tipo_producto']) : '';
            if (empty($tipo_producto)) {
                $errores[] = "El tipo de producto es obligatorio";
            }

            $cantidad = isset($_POST['cantidad']) ? trim($_POST['cantidad']) : '';
            if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
                $errores[] = "La cantidad debe ser un número positivo";
            }

            $fecha_recepcion = isset($_POST['fecha_recepcion']) ? trim($_POST['fecha_recepcion']) : '';
            if (empty($fecha_recepcion)) {
                $errores[] = "La fecha de recepción es obligatoria";
            }

            if (count($errores) > 0) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?controlador=Donacion&metodo=listar');
                exit;
            }

            // Crear donación
            require_once($this->config['dir_modelos'] . 'donacion.php');
            
            $unidad_medida = isset($_POST['unidad_medida']) ? trim($_POST['unidad_medida']) : 'unidades';
            $fecha_caducidad = isset($_POST['fecha_caducidad']) && !empty($_POST['fecha_caducidad']) ? trim($_POST['fecha_caducidad']) : null;
            $punto_distribucion_id = isset($_POST['punto_distribucion_id']) && !empty($_POST['punto_distribucion_id']) ? (int)$_POST['punto_distribucion_id'] : null;
            $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';

            $donacion = new Donacion(
                $nombre_donante,
                $tipo_producto,
                (int)$cantidad,
                $unidad_medida,
                $fecha_recepcion,
                $fecha_caducidad,
                $punto_distribucion_id,
                $observaciones
            );

            $donacion->guardar();

            header('Location: index.php?controlador=Donacion&metodo=listar&mensaje=creado');
            exit;

        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Actualiza una donación existente (solo admin)
     */
    public function actualizar() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?controlador=Donacion&metodo=listar');
                exit;
            }

            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if ($id <= 0) {
                throw new Exception("ID de donación no válido");
            }

            // Validar campos
            $errores = [];
            
            $nombre_donante = isset($_POST['nombre_donante']) ? trim($_POST['nombre_donante']) : '';
            if (empty($nombre_donante)) {
                $errores[] = "El nombre del donante es obligatorio";
            }

            $tipo_producto = isset($_POST['tipo_producto']) ? trim($_POST['tipo_producto']) : '';
            if (empty($tipo_producto)) {
                $errores[] = "El tipo de producto es obligatorio";
            }

            $cantidad = isset($_POST['cantidad']) ? trim($_POST['cantidad']) : '';
            if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
                $errores[] = "La cantidad debe ser un número positivo";
            }

            $fecha_recepcion = isset($_POST['fecha_recepcion']) ? trim($_POST['fecha_recepcion']) : '';
            if (empty($fecha_recepcion)) {
                $errores[] = "La fecha de recepción es obligatoria";
            }

            if (count($errores) > 0) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?controlador=Donacion&metodo=listar');
                exit;
            }

            // Actualizar donación
            require_once($this->config['dir_modelos'] . 'donacion.php');
            
            $donacion = Donacion::obtenerPorId($id);
            if (!$donacion) {
                throw new Exception("Donación no encontrada");
            }

            $donacion->setNombreDonante($nombre_donante);
            $donacion->setTipoProducto($tipo_producto);
            $donacion->setCantidad((int)$cantidad);
            $donacion->setUnidadMedida(isset($_POST['unidad_medida']) ? trim($_POST['unidad_medida']) : 'unidades');
            $donacion->setFechaRecepcion($fecha_recepcion);
            $donacion->setFechaCaducidad(isset($_POST['fecha_caducidad']) && !empty($_POST['fecha_caducidad']) ? trim($_POST['fecha_caducidad']) : null);
            $donacion->setPuntoDistribucionId(isset($_POST['punto_distribucion_id']) && !empty($_POST['punto_distribucion_id']) ? (int)$_POST['punto_distribucion_id'] : null);
            $donacion->setObservaciones(isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '');
            $donacion->setEstado(isset($_POST['estado']) ? trim($_POST['estado']) : 'recibido');

            $donacion->actualizar();

            header('Location: index.php?controlador=Donacion&metodo=listar&mensaje=actualizado');
            exit;

        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Elimina una donación (solo admin)
     */
    public function eliminar() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            Sesion::requiereAdmin();

            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($id <= 0) {
                throw new Exception("ID de donación no válido");
            }

            require_once($this->config['dir_modelos'] . 'donacion.php');
            
            Donacion::eliminar($id);

            header('Location: index.php?controlador=Donacion&metodo=listar&mensaje=eliminado');
            exit;

        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Muestra un error
     */
    private function mostrarError($exception) {
        if ($this->config['debug']) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
            echo "<h3>Error en gestión de donaciones:</h3>";
            echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
            echo "<p><strong>Archivo:</strong> " . $exception->getFile() . "</p>";
            echo "<p><strong>Línea:</strong> " . $exception->getLine() . "</p>";
            echo "<pre>" . $exception->getTraceAsString() . "</pre>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
            echo "<h3>Error</h3>";
            echo "<p>Ha ocurrido un error al gestionar las donaciones. Contacte al administrador.</p>";
            echo "</div>";
        }
    }
}
?>
