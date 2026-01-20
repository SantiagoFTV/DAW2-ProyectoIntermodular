<?php
/**
 * Controlador de Beneficiarios
 * Gestiona la lógica de la HU-03: Asignación Inteligente a Beneficiarios
 */

class ControladorBeneficiario {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Lista todos los beneficiarios
     */
    public function listar() {
        try {
            require_once($this->config['dir_modelos'] . 'beneficiario.php');
            $beneficiarios = Beneficiario::listar();
            $puntos_distribucion = $this->obtenerPuntosDistribucion();

            $beneficiarios_vista = $beneficiarios;
            $puntos_distribucion_vista = $puntos_distribucion;
            $config = $this->config;

            require_once($this->config['dir_vistas'] . 'gestion_beneficiarios.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Busca beneficiarios por término
     */
    public function buscar() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $termino = isset($_POST['termino_busqueda']) ? trim($_POST['termino_busqueda']) : '';

            if (empty($termino)) {
                $this->listar();
                return;
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');
            $beneficiarios = Beneficiario::buscar($termino);
            $puntos_distribucion = $this->obtenerPuntosDistribucion();

            $beneficiarios_vista = $beneficiarios;
            $puntos_distribucion_vista = $puntos_distribucion;
            $termino_busqueda = $termino;
            $config = $this->config;

            require_once($this->config['dir_vistas'] . 'gestion_beneficiarios.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Muestra los detalles de un beneficiario
     */
    public function detalles() {
        try {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

            if ($id <= 0) {
                throw new Exception("ID de beneficiario no válido");
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');
            $beneficiario = Beneficiario::obtenerPorId($id);

            if (!$beneficiario) {
                throw new Exception("Beneficiario no encontrado");
            }

            $historial_asignaciones = $beneficiario->obtenerHistorialAsignaciones();
            $puntos_distribucion = $this->obtenerPuntosDistribucion();

            $beneficiario_vista = $beneficiario;
            $historial_vista = $historial_asignaciones;
            $puntos_distribucion_vista = $puntos_distribucion;
            $config = $this->config;

            require_once($this->config['dir_vistas'] . 'detalles_beneficiario.html');
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Crea un nuevo beneficiario
     */
    public function crear() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
            $numero_identificacion = isset($_POST['numero_identificacion']) ? trim($_POST['numero_identificacion']) : '';
            $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
            $tamaño_familiar = isset($_POST['tamaño_familiar']) ? (int) $_POST['tamaño_familiar'] : 0;
            $necesidades = isset($_POST['necesidades']) ? trim($_POST['necesidades']) : '';

            // Validaciones
            if (empty($nombre) || empty($apellidos)) {
                throw new Exception("Nombre y apellidos son requeridos");
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');

            $beneficiario = new Beneficiario($nombre, $apellidos, $numero_identificacion, $telefono, $email, $direccion, $tamaño_familiar, $necesidades);
            $beneficiario->guardar();

            // Redirigir a listar con mensaje de éxito
            header('Location: index.php?controlador=Beneficiario&metodo=listar&mensaje=creado');
            exit;
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Actualiza un beneficiario
     */
    public function actualizar() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->detalles();
                return;
            }

            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id <= 0) {
                throw new Exception("ID de beneficiario no válido");
            }

            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
            $numero_identificacion = isset($_POST['numero_identificacion']) ? trim($_POST['numero_identificacion']) : '';
            $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
            $tamaño_familiar = isset($_POST['tamaño_familiar']) ? (int) $_POST['tamaño_familiar'] : 0;
            $necesidades = isset($_POST['necesidades']) ? trim($_POST['necesidades']) : '';
            $estado_validacion = isset($_POST['estado_validacion']) ? trim($_POST['estado_validacion']) : 'pendiente';

            // Validaciones
            if (empty($nombre) || empty($apellidos)) {
                throw new Exception("Nombre y apellidos son requeridos");
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');

            $beneficiario = Beneficiario::obtenerPorId($id);
            if (!$beneficiario) {
                throw new Exception("Beneficiario no encontrado");
            }

            $beneficiario->setNombre($nombre);
            $beneficiario->setApellidos($apellidos);
            $beneficiario->setNumeroIdentificacion($numero_identificacion);
            $beneficiario->setTelefono($telefono);
            $beneficiario->setEmail($email);
            $beneficiario->setDireccion($direccion);
            $beneficiario->setTamañoFamiliar($tamaño_familiar);
            $beneficiario->setNecesidades($necesidades);
            $beneficiario->setEstadoValidacion($estado_validacion);
            $beneficiario->actualizar();

            header('Location: index.php?controlador=Beneficiario&metodo=detalles&id=' . $id . '&mensaje=actualizado');
            exit;
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Elimina un beneficiario
     */
    public function eliminar() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            if ($id <= 0) {
                throw new Exception("ID de beneficiario no válido");
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');
            Beneficiario::eliminar($id);

            header('Location: index.php?controlador=Beneficiario&metodo=listar&mensaje=eliminado');
            exit;
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Asigna productos a un beneficiario
     */
    public function asignarProductos() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->detalles();
                return;
            }

            $beneficiario_id = isset($_POST['beneficiario_id']) ? (int) $_POST['beneficiario_id'] : 0;
            $productos = isset($_POST['productos']) ? $_POST['productos'] : [];
            $punto_distribucion_id = isset($_POST['punto_distribucion_id']) ? (int) $_POST['punto_distribucion_id'] : 0;
            $coordinador = isset($_POST['coordinador']) ? trim($_POST['coordinador']) : 'Sistema';
            $notas = isset($_POST['notas']) ? trim($_POST['notas']) : '';

            if ($beneficiario_id <= 0) {
                throw new Exception("Beneficiario no válido");
            }

            if (empty($productos)) {
                throw new Exception("Debe seleccionar al menos un producto");
            }

            require_once($this->config['dir_modelos'] . 'beneficiario.php');

            $beneficiario = Beneficiario::obtenerPorId($beneficiario_id);
            if (!$beneficiario) {
                throw new Exception("Beneficiario no encontrado");
            }

            // Verificar frecuencia
            if (!$beneficiario->puedeRecibirAsignacion()) {
                $fecha_ultima = $beneficiario->getFechaUltimaAsignacion();
                if ($fecha_ultima) {
                    $fecha_proxima = date('d/m/Y', strtotime($fecha_ultima . ' + ' . $beneficiario->getFrecuenciaMaximaDias() . ' days'));
                } else {
                    $fecha_proxima = 'desconocida';
                }
                throw new Exception("El beneficiario no puede recibir asignaciones hasta " . $fecha_proxima);
            }

            // Procesar cada producto
            $asignaciones_ids = [];
            foreach ($productos as $producto_data) {
                if (isset($producto_data['nombre']) && isset($producto_data['cantidad'])) {
                    $id = $beneficiario->asignarProducto(
                        $producto_data['nombre'],
                        (int) $producto_data['cantidad'],
                        $punto_distribucion_id,
                        $coordinador,
                        $notas
                    );
                    $asignaciones_ids[] = $id;
                }
            }

            // Generar comprobante
            $this->generarComprobante($beneficiario, $asignaciones_ids);

            header('Location: index.php?controlador=Beneficiario&metodo=detalles&id=' . $beneficiario_id . '&mensaje=asignado');
            exit;
        } catch (Throwable $exception) {
            $this->mostrarError($exception);
        }
    }

    /**
     * Genera un comprobante de asignación
     */
    private function generarComprobante($beneficiario, $asignaciones_ids) {
        try {
            $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Asignación</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .datos { margin: 20px 0; }
        .datos p { margin: 5px 0; }
        .productos { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .productos th { background-color: #007bff; color: white; padding: 10px; text-align: left; }
        .productos td { padding: 8px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 30px; text-align: center; border-top: 2px solid #333; padding-top: 10px; }
        .timestamp { color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>COMPROBANTE DE ASIGNACIÓN DE PRODUCTOS</h1>
        <p class="timestamp">Fecha: ' . date('d/m/Y H:i:s') . '</p>
    </div>
    
    <div class="datos">
        <h3>Datos del Beneficiario</h3>
        <p><strong>Nombre:</strong> ' . htmlspecialchars($beneficiario->getNombre() . ' ' . $beneficiario->getApellidos()) . '</p>
        <p><strong>Número de Identificación:</strong> ' . htmlspecialchars($beneficiario->getNumeroIdentificacion()) . '</p>
        <p><strong>Teléfono:</strong> ' . htmlspecialchars($beneficiario->getTelefono()) . '</p>
        <p><strong>Dirección:</strong> ' . htmlspecialchars($beneficiario->getDireccion()) . '</p>
        <p><strong>Tamaño Familiar:</strong> ' . $beneficiario->getTamañoFamiliar() . '</p>
    </div>

    <div class="productos">
        <h3>Productos Asignados</h3>
        <table class="productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha Asignación</th>
                </tr>
            </thead>
            <tbody>';

            require_once($this->config['dir_modelos'] . 'beneficiario.php');
            $historial = $beneficiario->obtenerHistorialAsignaciones();

            foreach ($historial as $asignacion) {
                $html .= '<tr>
                    <td>' . htmlspecialchars($asignacion['nombre_producto']) . '</td>
                    <td>' . $asignacion['cantidad'] . '</td>
                    <td>' . date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) . '</td>
                </tr>';
            }

            $html .= '</tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este comprobante certifica la asignación de productos al beneficiario.</p>
        <p>Sistema de Gestión de Voluntarios - Ayuda Solidaria</p>
    </div>
</body>
</html>';

            $filename = 'comprobante_' . $beneficiario->getId() . '_' . time() . '.html';
            file_put_contents($this->config['dir_vistas'] . '../../../comprobantes/' . $filename, $html);

        } catch (Exception $e) {
            // El error en generar el comprobante no debe detener el proceso principal
            error_log("Error generando comprobante: " . $e->getMessage());
        }
    }

    /**
     * Obtiene los puntos de distribución disponibles
     */
    private function obtenerPuntosDistribucion() {
        try {
            require_once($this->config['dir_modelos'] . 'bd.php');
            $bd = new BD();
            $sql = "SELECT id, nombre FROM puntos_distribucion ORDER BY nombre ASC";
            return $bd->seleccionar($sql);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Muestra mensajes de error
     */
    private function mostrarError($exception) {
        if ($this->config['debug']) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
            echo "<h3>Error en la aplicación:</h3>";
            echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
            echo "<p><strong>Archivo:</strong> " . $exception->getFile() . "</p>";
            echo "<p><strong>Línea:</strong> " . $exception->getLine() . "</p>";
            echo "</div>";
        } else {
            echo "Error en ControladorBeneficiario.php";
        }
        die();
    }
}
?>
