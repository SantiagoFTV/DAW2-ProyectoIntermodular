<?php
// index.php
$config = require 'config.php';

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
// Se acepta el parámetro GET/POST `acciones` (nuevo) o `controlador` (antiguo) y `metodo`
$metodo = isset($_GET['metodo']) ? $_GET['metodo'] : (isset($_POST['metodo']) ? $_POST['metodo'] : 'listar');
$acciones = isset($_GET['acciones']) ? $_GET['acciones'] : (isset($_POST['acciones']) ? $_POST['acciones'] : null);
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : ($acciones ?? 'Voluntario');

// Mapear acciones a controladores si se usa el parámetro 'acciones'
$mapeoAcciones = [
    'voluntarios' => 'Voluntario',
    'puntos' => 'PuntoDistribucion',
    'alertas' => 'AlertaCaducidad'
];

if ($acciones && isset($mapeoAcciones[$acciones])) {
    $controlador = $mapeoAcciones[$acciones];
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