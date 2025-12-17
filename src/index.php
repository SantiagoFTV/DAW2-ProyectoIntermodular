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
// Acepta: ?metodo=voluntarios o ?controlador=Voluntario&metodo=crear o ?controlador=Voluntario&accion=crear
$metodoParam = isset($_GET['metodo']) ? $_GET['metodo'] : (isset($_POST['metodo']) ? $_POST['metodo'] : null);
$accionParam = isset($_GET['accion']) ? $_GET['accion'] : (isset($_POST['accion']) ? $_POST['accion'] : null);
$controladorParam = isset($_GET['controlador']) ? $_GET['controlador'] : (isset($_POST['controlador']) ? $_POST['controlador'] : null);

// Mapeo de atajos a controladores
$mapeoControladores = [
    'voluntarios' => 'Voluntario',
    'puntos' => 'PuntoDistribucion',
    'alertas' => 'AlertaCaducidad'
];

// Determinar el controlador
if ($controladorParam) {
    $controlador = $controladorParam;
} elseif ($metodoParam && isset($mapeoControladores[$metodoParam])) {
    $controlador = $mapeoControladores[$metodoParam];
} else {
    $controlador = 'Voluntario';
}

// Determinar la acción (acepta tanto 'metodo' como 'accion' cuando se usa con controlador)
if ($accionParam) {
    $accion = $accionParam;
} elseif ($controladorParam && $metodoParam) {
    // Si se usa ?controlador=X&metodo=Y, metodo es la acción
    $accion = $metodoParam;
} else {
    $accion = 'listar';
}

$nombreControlador = 'Controlador' . ucfirst($controlador);

if (file_exists('./www/controladores/' . $nombreControlador . '.php')) {
    $controladorInstancia = new $nombreControlador($config);
    
    if (method_exists($controladorInstancia, $accion)) {
        $controladorInstancia->$accion();
    } else {
        echo "Método $accion no encontrado en $nombreControlador";
    }
} else {
    echo "Controlador $nombreControlador no encontrado";
}
?>