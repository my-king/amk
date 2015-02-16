<?php

class NoticeController extends TMetroUI {

    public function index() {
        RedirectorHelper::goToAction('acessoNegado');
    }

    public function acessoNegado() {
        /* Definir a aba que vai ser aberta */
        $this->addDados("modulo", $this->getParam("md"));
        $this->addDados("pagina", $this->getParam("pg"));

        if ($this->getParam("md") === 'AllowedAccess') {
            $this->TDialog('acessoNegado');
        } else {
            $this->TPageSecondary('acessoNegado');
        }
    }

    public function errorConnection() {
        echo 'Error na base de dados';
    }

}