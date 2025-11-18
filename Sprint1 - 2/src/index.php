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
// Se acepta el parámetro GET `controlador` y `metodo`
$metodo = isset($_GET['metodo']) ? $_GET['metodo'] : 'listar';
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'Voluntario';

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