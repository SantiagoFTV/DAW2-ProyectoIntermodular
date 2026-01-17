<?php
/**
 * Clase para manejar sesiones y autenticación
 */
class Sesion {
    const USUARIO_ADMIN = 'admin';
    const USUARIO_NORMAL = 'usuario';
    
    // Credenciales hardcodeadas (en producción usar BD)
    private static $usuarios = [
        'admin' => ['password' => 'admin123', 'rol' => self::USUARIO_ADMIN],
        'user' => ['password' => 'user123', 'rol' => self::USUARIO_NORMAL]
    ];

    public static function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($usuario, $password) {
        self::iniciarSesion();
        
        if (!isset(self::$usuarios[$usuario])) {
            return false;
        }
        
        if (self::$usuarios[$usuario]['password'] !== $password) {
            return false;
        }
        
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = self::$usuarios[$usuario]['rol'];
        $_SESSION['autenticado'] = true;
        
        return true;
    }

    public static function logout() {
        self::iniciarSesion();
        session_destroy();
    }

    public static function estaAutenticado() {
        self::iniciarSesion();
        return isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true;
    }

    public static function obtenerUsuario() {
        self::iniciarSesion();
        return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
    }

    public static function obtenerRol() {
        self::iniciarSesion();
        return isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
    }

    public static function esAdmin() {
        self::iniciarSesion();
        return isset($_SESSION['rol']) && $_SESSION['rol'] === self::USUARIO_ADMIN;
    }

    public static function esUsuarioNormal() {
        self::iniciarSesion();
        return isset($_SESSION['rol']) && $_SESSION['rol'] === self::USUARIO_NORMAL;
    }

    public static function requiereAdmin() {
        if (!self::estaAutenticado()) {
            header('Location: index.php?controlador=Auth&metodo=login');
            exit;
        }
        
        if (!self::esAdmin()) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
            echo "<h3>Acceso denegado</h3>";
            echo "<p>No tienes permisos para acceder a este apartado. Solo los administradores pueden acceder.</p>";
            echo "<a href='index.php?controlador=Home&metodo=listar' style='color: #721c24; text-decoration: underline;'>Volver al inicio</a>";
            echo "</div>";
            exit;
        }
    }

    public static function requiereAutenticacion() {
        if (!self::estaAutenticado()) {
            header('Location: index.php?controlador=Auth&metodo=login');
            exit;
        }
    }
}
?>
