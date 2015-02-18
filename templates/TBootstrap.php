<?php

/**
 * Template baseado no Bootstrap
 * @link http://getbootstrap.com/ version v3.3.2
 * @author Igor da Hora <igordahora@gmail.com.br>
 */
class TBootstrap extends Controller {

    public $HTML;

    public function __construct() {
        parent::__construct();

        /* Constantes */
        define("TEMPLATE", __CLASS__);
        define("PATH_DIR_TEMPLATE_URL", PATH_TEMPLATE_URL . TEMPLATE . "/");
        define("PATH_TEMPLATE_JS_URL", PATH_DIR_TEMPLATE_URL . "js/");
        define("PATH_TEMPLATE_CSS_URL", PATH_DIR_TEMPLATE_URL . "css/");
        define("PATH_TEMPLATE_IMAGE_URL", PATH_DIR_TEMPLATE_URL . "images/");

        /* Class */
        $this->HTML = new THtmlHelper();
    }

    public function init() {

        parent::init();

        # Definir meta tag
        $this->HTML->addMetaHttpEquiv();
        $this->HTML->addMetaViewPort();

        # Definir icon padrão do sistema
        $this->HTML->setIcon(PATH_TEMPLATE_IMAGE_URL . "favicon.ico");

        # Definir nome da pagina
        $this->HTML->setTitle(strtoupper(NAME_SIS) . " - {$this->_controller}/{$this->_action}");

        $this->HTML->addJavaScript(PATH_JS_CORE_URL . 'core.js', true); // 3 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . 'bootstrap.min.js', true); // 2 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery.min.js", true); //1 a entrar

        //$this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "bootstrap-theme.min.css", true); //2 entrar
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "bootstrap.min.css", true); //1 entrar
    }

    public function TPage($nome) {

        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        $this->view($nome);

        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom_adiministrator.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom_adiministrator.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

}
