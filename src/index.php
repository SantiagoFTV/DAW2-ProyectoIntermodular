<?php
// index.php
$config = require 'config.php';

// Iniciar sesiones
session_start();

// Cargar clases automáticamente
spl_autoload_register(function($clase) {
    $directorios = ['./www/controladores/', './www/modelos/', ''];
    
    foreach ($directorios as $directorio) {
        if (file_exists($directorio . $clase . '.php')) {
            require_once $directorio . $clase . '.php';
            return;
        }
    }
});

// Enrutamiento básico
// Preferimos valores enviados por POST para evitar que los parámetros de la URL (GET)
// sobreescriban envíos de formularios (caso de formularios que se envían desde la misma página).
// Se acepta el parámetro GET/POST `acciones` (nuevo) o `controlador` (antiguo) y `metodo`.
$metodo = isset($_POST['metodo']) ? $_POST['metodo'] : (isset($_GET['metodo']) ? $_GET['metodo'] : 'listar');
$acciones = isset($_POST['acciones']) ? $_POST['acciones'] : (isset($_GET['acciones']) ? $_GET['acciones'] : null);
$controlador = isset($_POST['controlador']) ? $_POST['controlador'] : (isset($_GET['controlador']) ? $_GET['controlador'] : ($acciones ?? 'Home'));

// Mapear acciones a controladores si se usa el parámetro 'acciones'
$mapeoAcciones = [
    'voluntarios' => 'Voluntario',
    'puntos' => 'PuntoDistribucion',
    'alertas' => 'AlertaCaducidad',
    'beneficiarios' => 'Beneficiario',
    'home' => 'Home',
    'inicio' => 'Home'
];

if ($acciones && isset($mapeoAcciones[$acciones])) {
    $controlador = $mapeoAcciones[$acciones];
}

// Controladores que no requieren autenticación
$controladores_publicos = ['Auth'];

// Validar autenticación para controladores protegidos
if (!in_array($controlador, $controladores_publicos)) {
    require_once('./www/modelos/Sesion.php');
    
    if (!Sesion::estaAutenticado()) {
        header('Location: index.php?controlador=Auth&metodo=login');
        exit;
    }

    // Validar permisos según rol
    $usuario_normal_puede_acceder = ['Home', 'PuntoDistribucion', 'Beneficiario'];
    
    if (Sesion::esUsuarioNormal() && !in_array($controlador, $usuario_normal_puede_acceder)) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px;'>";
        echo "<h3>Acceso denegado</h3>";
        echo "<p>No tienes permisos para acceder a este apartado. Solo los administradores pueden acceder a Voluntarios y Alertas de Caducidad.</p>";
        echo "<a href='index.php?controlador=Home&metodo=listar' style='color: #721c24; text-decoration: underline;'>Volver al inicio</a>";
        echo "</div>";
        exit;
    }
}

$nombreControlador = 'Controlador' . ucfirst($controlador);

if (file_exists('./www/controladores/' . $nombreControlador . '.php')) {
    $controladorInstancia = new $nombreControlador($config);
    
    if (method_exists($controladorInstancia, $metodo)) {
        $controladorInstancia->$metodo();
    } else {
        echo "Método $metodo no encontrado en $nombreControlador";
    }
} else {
    echo "Controlador $nombreControlador no encontrado";
}
?>