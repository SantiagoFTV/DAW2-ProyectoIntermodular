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
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'Voluntario';

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