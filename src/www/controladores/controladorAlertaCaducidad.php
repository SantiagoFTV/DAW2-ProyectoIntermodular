<?php
/**
 * Controlador de Alertas de Caducidad
 */
class ControladorAlertaCaducidad {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function listar() {
        try {
            require_once($this->config['dir_modelos'] . 'alertaCaducidad.php');
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            
            $alertas = AlertaCaducidad::listar();
            $puntos = PuntoDistribucion::listar();
            
            $alertas_vista = $alertas;
            $puntos_vista = $puntos;
            $config = $this->config;
            
            require_once($this->config['dir_vistas'] . 'gestion_alertas_caducidad.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception, 'Error al listar alertas de caducidad');
        }
    }

    public function crear() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $nombre_producto = isset($_POST['nombre_producto']) ? trim($_POST['nombre_producto']) : '';
            $punto_distribucion_id = isset($_POST['punto_distribucion_id']) ? trim($_POST['punto_distribucion_id']) : '';
            $cantidad = isset($_POST['cantidad']) ? trim($_POST['cantidad']) : '';
            $fecha_caducidad = isset($_POST['fecha_caducidad']) ? trim($_POST['fecha_caducidad']) : '';
            $ubicacion = isset($_POST['ubicacion']) ? trim($_POST['ubicacion']) : '';

            // Validaciones
            if ($nombre_producto === '' || $punto_distribucion_id === '' || $cantidad === '' || $fecha_caducidad === '' || $ubicacion === '') {
                $this->listarConMensaje('Todos los campos son obligatorios.', 'error');
                return;
            }

            if (!is_numeric($cantidad) || $cantidad <= 0) {
                $this->listarConMensaje('La cantidad debe ser un número positivo.', 'error');
                return;
            }

            // Validar que la fecha sea válida
            if (!$this->validarFecha($fecha_caducidad)) {
                $this->listarConMensaje('La fecha de caducidad no es válida. Use formato YYYY-MM-DD.', 'error');
                return;
            }

            require_once($this->config['dir_modelos'] . 'alertaCaducidad.php');
            $alerta = new AlertaCaducidad($nombre_producto, $punto_distribucion_id, $cantidad, $fecha_caducidad, $ubicacion);
            $id = $alerta->guardar();

            $diasRestantes = $alerta->getDiasRestantes();
            $estado = $alerta->getEstado();
            $mensaje = "Alerta de caducidad registrada: <strong>{$nombre_producto}</strong> (Caducidad: {$fecha_caducidad}, Días restantes: {$diasRestantes}).";
            $this->listarConMensaje($mensaje, 'success');
        } catch (Throwable $exception) {
            if ($this->config['debug']) {
                $this->mostrarError($exception, 'Error al crear alerta de caducidad');
            } else {
                $this->listarConMensaje('No se pudo guardar la alerta. Contacte al administrador.', 'error');
            }
        }
    }

    public function eliminar() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            
            if ($id === '' || !is_numeric($id)) {
                $this->listarConMensaje('ID de alerta inválido.', 'error');
                return;
            }

            require_once($this->config['dir_modelos'] . 'alertaCaducidad.php');
            AlertaCaducidad::eliminar($id);

            $this->listarConMensaje('Alerta de caducidad eliminada correctamente.', 'success');
        } catch (Throwable $exception) {
            if ($this->config['debug']) {
                $this->mostrarError($exception, 'Error al eliminar alerta');
            } else {
                $this->listarConMensaje('No se pudo eliminar la alerta. Contacte al administrador.', 'error');
            }
        }
    }

    public function filtrar() {
        try {
            $filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : 'todas';
            
            if (!in_array($filtro, ['todas', 'criticas', 'caducadas', 'proximas'])) {
                $filtro = 'todas';
            }

            require_once($this->config['dir_modelos'] . 'alertaCaducidad.php');
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            
            if ($filtro === 'todas') {
                $alertas = AlertaCaducidad::listar();
            } else {
                $alertas = AlertaCaducidad::obtenerAlertas($filtro);
            }
            
            $puntos = PuntoDistribucion::listar();
            
            $alertas_vista = $alertas;
            $puntos_vista = $puntos;
            $filtro_actual = $filtro;
            $config = $this->config;
            
            require_once($this->config['dir_vistas'] . 'gestion_alertas_caducidad.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception, 'Error al filtrar alertas');
        }
    }

    private function listarConMensaje($mensaje, $tipo = 'success') {
        require_once($this->config['dir_modelos'] . 'alertaCaducidad.php');
        require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
        
        $alertas = AlertaCaducidad::listar();
        $puntos = PuntoDistribucion::listar();
        
        $alertas_vista = $alertas;
        $puntos_vista = $puntos;
        $mensaje_vista = $mensaje;
        $tipo_mensaje = $tipo;
        $config = $this->config;
        
        require_once($this->config['dir_vistas'] . 'gestion_alertas_caducidad.html');
    }

    private function validarFecha($fecha) {
        $formato = 'Y-m-d';
        $date = DateTime::createFromFormat($formato, $fecha);
        return $date && $date->format($formato) === $fecha;
    }

    private function mostrarError(Throwable $exception, $fallback) {
        if ($this->config['debug']) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
            echo "<h3>{$fallback}</h3>";
            echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
            echo "<p><strong>Archivo:</strong> " . $exception->getFile() . "</p>";
            echo "<p><strong>Línea:</strong> " . $exception->getLine() . "</p>";
            echo "</div>";
        } else {
            echo $fallback;
        }
        die();
    }
}
?>
