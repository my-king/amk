<?php

class AdministratorController extends TBootstrap {

    public function index() {
        /* JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");
        /* Adicionar dados a view */
        $this->addDados('isDatabase', ProjetoDatabaseHelper::isDatabase());
        $this->addDados('database', ProjetoDatabaseHelper::getDatabase());
        /* Exibir view */
        $this->TPage('index');
    }

    public function persistencia() {
        /* JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");
        /* Adicionar dados a view */
        $this->addDados('isDatabase', PersistenciaDatabaseHelper::isDatabase());
        $this->addDados('database', PersistenciaDatabaseHelper::getDatabase());
        /* Exibir view */
        $this->TPage('persistencia');
    }

}
