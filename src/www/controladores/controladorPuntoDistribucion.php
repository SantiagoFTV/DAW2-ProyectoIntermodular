<?php
/**
 * Controlador de Puntos de Distribución
 */
class ControladorPuntoDistribucion {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function listar() {
        try {
            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            $puntos = PuntoDistribucion::listar();
            $puntos_vista = $puntos;
            $config = $this->config;
            require_once($this->config['dir_vistas'] . 'gestion_puntos_distribucion.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception, 'Error al listar puntos de distribución');
        }
    }

    public function crear() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
            $responsable = isset($_POST['responsable']) ? trim($_POST['responsable']) : '';
            $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
            $horario = isset($_POST['horario']) ? trim($_POST['horario']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

            if ($nombre === '' || $direccion === '' || $responsable === '' || $telefono === '') {
                $this->listarConMensaje('Nombre, dirección, responsable y teléfono son obligatorios.', 'error');
                return;
            }

            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            $punto = new PuntoDistribucion($nombre, $direccion, $responsable, $telefono, null, null, $horario, $descripcion === '' ? null : $descripcion);
            $id = $punto->guardar();

            $mensaje = "Punto de distribución <strong>{$nombre}</strong> registrado (ID: {$id}).";
            $this->listarConMensaje($mensaje, 'success');
        } catch (Throwable $exception) {
            if ($this->config['debug']) {
                $this->mostrarError($exception, 'Error al crear punto de distribución');
            } else {
                $this->listarConMensaje('No se pudo guardar el punto. Contacte al administrador.', 'error');
            }
        }
    }

    public function eliminar() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            if ($id <= 0) {
                $this->listarConMensaje('ID no válido para eliminar.', 'error');
                return;
            }

            require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
            PuntoDistribucion::eliminar($id);
            $this->listarConMensaje('Punto eliminado correctamente.', 'success');
        } catch (Throwable $exception) {
            if ($this->config['debug']) {
                $this->mostrarError($exception, 'Error al eliminar punto de distribución');
            } else {
                $this->listarConMensaje('No se pudo eliminar el punto. Contacte al administrador.', 'error');
            }
        }
    }

    private function listarConMensaje($mensaje, $tipo = 'success') {
        require_once($this->config['dir_modelos'] . 'puntoDistribucion.php');
        $puntos = PuntoDistribucion::listar();
        $puntos_vista = $puntos;
        $mensaje_vista = $mensaje;
        $tipo_mensaje = $tipo;
        $config = $this->config;
        require_once($this->config['dir_vistas'] . 'gestion_puntos_distribucion.html');
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
