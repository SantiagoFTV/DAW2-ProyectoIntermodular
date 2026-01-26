<?php
/**
 * Controlador de Autenticación
 * Gestiona login y logout del sistema
 */
class ControladorAuth {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Muestra el formulario de login y procesa credenciales
     */
    public function login() {
        try {
            require_once($this->config['dir_modelos'] . 'Sesion.php');
            
            $mensaje = '';
            $tipo_mensaje = '';

            // Procesar formulario POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';

                if ($usuario === '' || $password === '') {
                    $mensaje = ' Usuario y contraseña son obligatorios.';
                    $tipo_mensaje = 'error';
                } else {
                    if (Sesion::login($usuario, $password)) {
                        header('Location: index.php?controlador=Home&metodo=listar');
                        exit;
                    } else {
                        $mensaje = ' Usuario o contraseña incorrectos.';
                        $tipo_mensaje = 'error';
                    }
                }
            }

            $config = $this->config;
            $mensaje_vista = $mensaje;
            $tipo_mensaje_vista = $tipo_mensaje;
            require_once('./www/vistas/login.html');

        } catch (Throwable $exception) {
            if ($this->config['debug']) {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
                echo "<h3>Error en autenticación:</h3>";
                echo "<p><strong>Mensaje:</strong> " . $exception->getMessage() . "</p>";
                echo "</div>";
            } else {
                echo "Error en autenticación. Contacte al administrador.";
            }
        }
    }

    /**
     * Cierra sesión y redirige al login
     */
    public function logout() {
        require_once($this->config['dir_modelos'] . 'Sesion.php');
        Sesion::logout();
        header('Location: index.php?controlador=Auth&metodo=login');
        exit;
    }
}
?>
