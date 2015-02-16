<?php

class IndexController extends TMetroUI {

    public function index() {
        RedirectorHelper::goToAction('logon');
    }

    public function logon() {
        # Adicionar titulo a pagina
        $this->HTML->setTitle("Login");

        /* JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");

        $objDatabaseLogic = new DatabaseLogic();
        $objDatabaseLogic->listSistemas();
        $this->addDados('listSistemas', TFormHelper::optionSelectObject($objDatabaseLogic->listSistemas(), 'id', 'nome'));
                
        # Startar Template
        $this->TStart("logon");
    }

}