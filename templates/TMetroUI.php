<?php

/**
 * Description of Win8
 * @author igor
 */
class TMetroUI extends Controller {

    public $HTML;
    public $SECURITY;

    public function __construct() {

        parent::__construct();

        # Constantes
        define("TEMPLATE", __CLASS__);
        define("PATH_DIR_TEMPLATE_URL", PATH_TEMPLATE_URL . TEMPLATE . "/");
        define("PATH_TEMPLATE_JS_URL", PATH_DIR_TEMPLATE_URL . "js/");
        define("PATH_TEMPLATE_CSS_URL", PATH_DIR_TEMPLATE_URL . "css/");
        define("PATH_TEMPLATE_IMAGE_URL", PATH_DIR_TEMPLATE_URL . "images/");

        $this->HTML = new THtmlHelper();
        $this->SECURITY = SecurityHelper::getInstancia();
    }

    public function init() {

        parent::init();

        # Definir meta tag
        $this->HTML->addMetaViewPort();

        # Definir icon padrão do sistema
        $this->HTML->setIcon(PATH_IMAGE_URL . "favicon.ico");

        # Definir nome da pagina
        $this->HTML->setTitle(strtoupper(NAME_SIS) . " - {$this->_controller}/{$this->_action}");

        $this->HTML->addJavaScript(PATH_JS_CORE_URL . 'core.js', true); // 6 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . 'docs.js', true); // 5 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "load-metro.js", true); //4 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery/jquery.mousewheel.js", true); //3 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery/jquery.widget.min.js", true); //2 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery/jquery.min.js", true); //1 a entrar

        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "docs.css", true); //3 entrar
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "metro-bootstrap-responsive.css", true); //2 entrar
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "metro-bootstrap.css", true); //1 entrar
        #feedback
        if ($this->_action !== 'deslogar') {
            $script = TFeedbackHelper::displayFeedback();
            $this->HTML->addHeadContent($script);
        }

        # Configurar Body
        $this->HTML->setBodyAttribute('class="metro"');
    }

    public function TStart($nome) {

        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        $this->view($nome);

        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        $this->HTML->setBodyAttribute('class="metro"');

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TMetro($nome) {
        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        $this->view($nome);

        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "start-screen.js");

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TPageSecondary($nome) {
        
        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        echo '<header class="bg-dark">';
        $this->viewCore('header');
        echo '</header>';

        //echo $this->BREADCRUMB;
        # Inicio da pagina
        echo '<div class="container">';
        TBreadCrumbHelper::start();
        # Incluir view no tamplate
        $this->view($nome);
        echo '</div>';
        # Fim da pagina
        # inicio rodapé
        echo '<div class="container">';
        $this->viewCore('footer');
        echo '</div>';
        # fim rodapé
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TPageOff($nome) {
        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        echo '<header class="bg-dark">';
        $this->viewCore('headerOff');
        echo '</header>';

        //echo $this->BREADCRUMB;
        # Inicio da pagina
        echo '<div class="container">';
        TBreadCrumbHelper::start();
        # Incluir view no tamplate
        $this->view($nome);
        echo '</div>';
        # Fim da pagina
        # inicio rodapé
        echo '<div class="container">';
        $this->viewCore('footer');
        echo '</div>';
        # fim rodapé
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TDialog($nome) {

        # Inicia o buffer
        ob_start();
        # Inicio da pagina
        echo '<div class="container">';
        $this->view($nome);
        echo '</div>';
        # Fim da pagina
        # inicio rodapé
        echo '<div class="container" id="footer-sedes">';
        $this->viewCore('footer');
        echo '</div>';
        # fim rodapé
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TImprimir($nome) {

        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        $this->view('impressora/' . $nome);

        # Pegar view e aloca numa variavel
        $content = "<div style='width:750px'>";
        $content .= ob_get_clean();
        $content.= "</div>";

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Inicia o buffer
        ob_start();

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

    public function TPdf($nome) {

        # Inicia o buffer
        ob_start();

        # Incluir view no tamplate 
        $this->view('pdf/' . $nome);

        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Inicia o buffer
        ob_start();

        # Imprime o HTML
        echo $this->HTML->getHtml();

        # Pegar view e aloca numa variavel
        $html = ob_get_clean();

        $gerarPdf = ExportarHelper::getInstancia();

        $gerarPdf->exportarPDF($html);
    }

}