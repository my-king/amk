<?php

class SecurityController extends TMetroUI {

    public function acessoNegado() {
        /* Definir a aba que vai ser aberta */
        $this->addDados("modulo", $this->getParam("md"));
        $this->addDados("pagina", $this->getParam("pg"));
        $this->TPageOff('acessoNegado');
    }

}
