<?php

class VEntityController extends TMetroUI {

    public function cadastrar() {
        /* Add JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");

        $objEntity = new EntityHelper();
        $this->addDados('reflection', $objEntity);
        $this->TPageSecondary('cadastro');
    }

    public function cadastrarVEntityFromDatabase() {

        if (isset($_POST['dal'])) {
            /* Add JS */
            $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
            $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");

            $this->addDados('dados', $_POST);

            $objEntity = new EntityHelper();
            $this->addDados('reflection', $objEntity);
            unset($objEntity);

            $DbmLogic = new DbmLogic();
            $this->addDados('colmaps', $DbmLogic->listColmaps($_POST['dal'], $_POST['schema'], $_POST['table'], $_POST['id']));
            unset($DbmLogic);

            $this->TPageSecondary('cadastroVEntityFromDatabase');
        } else {
            /* CSS */
            $this->HTML->addCss(PATH_DIR_TEMPLATE_URL . 'ext/select2/select2.css');
            /* Add JS */
            $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
            $this->HTML->addJavaScript(PATH_DIR_TEMPLATE_URL . 'ext/select2/select2.js');
            $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . "_filtro.js");

            $options = "<option></option>";
            foreach ($this->SECURITY->getSistema()->getConexoes() as $dal) {
                $options.="<option value='{$dal}'>{$dal}</option>";
            }
            $this->addDados('listOptionDal', $options);
            unset($options);

            $this->TPageSecondary('cadastroVEntityFromDatabaseFiltro');
        }
    }

    public function editar() {
        /* Incluir Biblioteca */
        include_once $this->SECURITY->getSistema()->getVEntity() . $this->getParam('file') . '.php';

        /* Add JS */
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.validate.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");

        $objEntity = new EntityHelper($this->getParam('file'));
        $this->addDados('reflection', $objEntity);
        $this->TPageSecondary('edita');
    }
    
    public function listColmaps() {

        /* JS */
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery/jquery.dataTables.js");
        $this->HTML->addJavaScript(PATH_JS_URL . $this->_controller . "/" . $this->_action . ".js");


        /* Definir a aba que vai ser aberta */
        $objTFrameActive = new TFrameActiveHelper('frameC', 'frame');
        $this->addDados('frameActive', $objTFrameActive);
        unset($objTFrameActive);

        /* Exibir view */
        $this->TDialog('listColmaps');
    }
    
}
