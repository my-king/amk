<?php

class IndexController extends TMetroUI {

    public function index() {
        RedirectorHelper::goToAction('logon');
    }

    public function logon() {
        
        if(!ProjetoDatabaseHelper::isDatabase()){
            RedirectorHelper::goToController('Administrator');
        }
        
        # Adicionar titulo a pagina
        $this->HTML->setTitle("Login");

        /* JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");

        /* Adicionar lista de sistemas a pagina */
        $this->addDados('listSistemas', TFormHelper::optionSelectObject(ProjetoDatabaseHelper::listSistemas(), 'id', 'nome'));
                
        # Startar Template
        $this->TStart("logon");
    }

}