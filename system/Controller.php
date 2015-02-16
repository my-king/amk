<?php

class Controller{

    private $DADOS;
    public $_controller;
    public $_action;
    
    public function __construct() {
        $this->DADOS = null;
        $this->_controller = CurrentUrlHelper::getController();
        $this->_action = CurrentUrlHelper::getAction();
    }

    public function init() {}

    public function addDados($name, $value) {
        $this->DADOS[$name] = $value;
    }

    public function getParam($name = null) {
        return CurrentUrlHelper::getParam($name);
    }

    public function isParam($name) {
        return CurrentUrlHelper::isParam($name);
    }

    public function view($nome) {
        if (is_array($this->DADOS) && count($this->DADOS) > 0) {
            extract($this->DADOS, EXTR_PREFIX_ALL, 'view');
        }

        $path = VIEWS . $this->_controller . "/" . $nome . '.phtml';

        if (!file_exists($path)) {
            RedirectorHelper::goToControllerAction("Errors", "VIEW_404");
        }

        return require_once ( $path );
    }

    public function viewCore($nome) {
        if (is_array($this->DADOS) && count($this->DADOS) > 0) {
            extract($this->DADOS, EXTR_PREFIX_ALL, 'view');
        }

        $path = VIEWS . "core/" . $nome . '.phtml';

        if (!file_exists($path)) {
            RedirectorHelper::goToControllerAction("Errors", "VIEW_404");
        }

        return require_once ( $path );
    }

}
