<?php
class ControladorHome {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function index() {
        $config = $this->config;
        require_once($this->config['dir_vistas'] . 'home.html');
    }

    public function listar() {
        $this->index();
    }
}
