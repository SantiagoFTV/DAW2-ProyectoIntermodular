<?php
/**
 * Controlador Home
 * Renderiza la vista principal del sistema
 */
class ControladorHome {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Renderiza la portada del sistema
     */
    public function index() {
        $config = $this->config;
        require_once($this->config['dir_vistas'] . 'home.html');
    }

    /**
     * Alias de index para compatibilidad
     */
    public function listar() {
        $this->index();
    }
}
