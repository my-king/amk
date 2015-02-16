<?php

class PrincipalController extends TMetroUI {

    public function index() {
        
        /* Adicionar JS a pagina */
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery/jquery.dataTables.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");
        
        /* Definir a aba que vai ser aberta */
        $objTFrameActive = new TFrameActiveHelper('frameE', 'frame');
        $this->addDados('frameActive', $objTFrameActive);
        unset($objTFrameActive);

        $this->TPageSecondary("index");
    }

}
