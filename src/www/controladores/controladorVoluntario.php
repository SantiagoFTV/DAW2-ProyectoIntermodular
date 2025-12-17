<?php
/**
 * Controlador de Voluntarios
 */
class ControladorVoluntario{
    private $config;

    public function __construct($config){
        $this->config = $config;
    }

    public function listar(){
        try{
            require_once($this->config['dir_modelos'].'voluntario.php');
            $voluntarios = Voluntario::listar();
            
            // Pasar variables a la vista (incluimos $config para que la vista pueda usar rutas)
            $voluntarios_vista = $voluntarios;
            $config = $this->config;
            require_once($this->config['dir_vistas'].'gestion_voluntarios.html');
            
        } catch(Throwable $exception){
            if($this->config['debug']) {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
                echo "<h3>Error en la aplicación:</h3>";
                echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
                echo "<p><strong>Archivo:</strong> " . $exception->getFile() . "</p>";
                echo "<p><strong>Línea:</strong> " . $exception->getLine() . "</p>";
                echo "</div>";
            } else {
                echo "Error en controladorVoluntario.php";
            }
            die();
        }
    }

    public function crear(){
        try{
            // Verificar si es una petición POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->listar();
                return;
            }

            // Sanitizar y trimar entradas
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
            $horas_disponibles = isset($_POST['horas_disponibles']) ? trim($_POST['horas_disponibles']) : '';
            $habilidades = isset($_POST['habilidades']) ? trim($_POST['habilidades']) : '';

            // Validaciones básicas
            if ($nombre === '' || $telefono === '' || $horas_disponibles === '') {
                $mensaje = "Error: Nombre, teléfono y horas son obligatorios";
                $this->listarConMensaje($mensaje, 'error');
                return;
            }

            // Convertir a NULL si no hay habilidades (pero conservar valores como "cocina, logística")
            if ($habilidades === '') {
                $habilidades = null;
            }

            require_once($this->config['dir_modelos'].'voluntario.php');
            $voluntario = new Voluntario($nombre, $telefono, $horas_disponibles, $habilidades);
            $id = $voluntario->guardar();
            
            $mensaje = "✅ El voluntario <strong>$nombre</strong> se registró correctamente (ID: $id).";
            $this->listarConMensaje($mensaje, 'success');
            
        } catch(Throwable $exception){
            if($this->config['debug']) {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
                echo "<h3>Error al crear voluntario:</h3>";
                echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
                echo "</div>";
            } else {
                $mensaje = "Error al guardar el voluntario. Contacte al administrador.";
                $this->listarConMensaje($mensaje, 'error');
            }
        }
    }

    private function listarConMensaje($mensaje, $tipo = 'success'){
        try {
            require_once($this->config['dir_modelos'].'voluntario.php');
            $voluntarios = Voluntario::listar();
            
            $voluntarios_vista = $voluntarios;
            $mensaje_vista = $mensaje;
            $tipo_mensaje = $tipo;
            $config = $this->config;
            require_once($this->config['dir_vistas'].'gestion_voluntarios.html');
        } catch (Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>