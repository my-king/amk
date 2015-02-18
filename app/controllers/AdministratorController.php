<?php

class AdministratorController extends TBootstrap {

    public function index() {
        /* JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");
        /* Adicionar dados a view */
        $this->addDados('isDatabase', DatabaseLogic::isDatabase());
        $this->addDados('database', DatabaseLogic::getDatabase());
        /* Exibir view */
        $this->TPage('index');
    }

}
