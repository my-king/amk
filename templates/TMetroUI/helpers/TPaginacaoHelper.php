<?php

/**
 * @author Igor da Hora <igordahora@gmail.com>
 * Class de criação de paginação
 */
class TPaginacaoHelper {

    private $_totalRegistros; // total de registros
    private $_resultadoPorPagina; // total de resultados por pagina
    private $_numeroDePaginas; // numero de paginas
    private $_inicio; // Primeira linha a ser mostrada
    private $_paginaAtual;
    private $_linkPage; //array de links

    public function __construct($totalRegistros, $pagina = null, $limit = null) {
        $this->setResultadoPorPagina(($limit === null) ? (int) LIMIT : (int) $limit );
        $this->_totalRegistros = (int) $totalRegistros;
        $this->_numeroDePaginas = (int) ceil($totalRegistros / $this->_resultadoPorPagina);
        $this->_paginaAtual = ($pagina !== null) ? (int) $pagina : 1;
        $this->_inicio = ($pagina !== null) ? ($this->_paginaAtual - 1) * $this->_resultadoPorPagina : 0;
    }

    private function setResultadoPorPagina($nResulatados) {
        $this->_resultadoPorPagina = $nResulatados;
    }

    public function getInicio() {
        return $this->_inicio;
    }

    #pegar o controller que estar sendo usado

    private function getCurrentController() {
        global $start;
        return $start->_controller;
    }

    #pegar o action que estar sendo usado

    private function getCurrentAction() {
        global $start;
        return $start->_action;
    }

    private function getIntervaloDaPagina() {
        $pagina = array();
        if ($this->_numeroDePaginas <= 10) {
            $pagina['inicio'] = 1;
            $pagina['fim'] = $this->_numeroDePaginas;
            return $pagina;
        } else {
            if( ($this->_paginaAtual + 5) > $this->_numeroDePaginas ){
                $pagina['inicio'] = $this->_numeroDePaginas - 9;
            }else {
                $pagina['inicio'] = ( ($this->_paginaAtual - 5) < 1 ) ? 1 : $this->_paginaAtual - 5;
            }
            $pagina['fim'] = 10;
            return $pagina;
        }
    }

    public function getPaginacao() {

        $pagina = $this->getIntervaloDaPagina();
        $countLink = $pagina['inicio'];
        for ($i = 1; $i <= $pagina['fim']; $i++) {
            $this->addPage($countLink);
            $countLink++;
        }
        unset($countLink);

        $html = "<div style='margin-top:10px;'>";
        $html .= "<div class='pagination' style='float:left;'>";
        $html .= "<ul>";
        if ($this->_numeroDePaginas > 1) {

            #exibir link para pagina anterior
            if ($this->_paginaAtual > 1) {
                $nPage = $this->_paginaAtual - 1;
                $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;
                $urlFirst = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/1';
                $html .= "<li class='first'>";
                $html .= "<a href='{$urlFirst}'><i class='icon-first-2'></i></a>";
                $html .= "</li>";
                $html .= "<li class='prev'>";
                $html .= "<a href='{$url}'><i class='icon-previous'></i></a>";
                $html .= "</li>";
            } else {
                $html .= "<li class='disabled'><a><i class='icon-first-2'></a></i></li>";
                $html .= "<li class='disabled'><a><i class='icon-previous'></a></i></li>";
            }


            #listar link das paginas
            foreach ($this->_linkPage as $value) {
                $html.= $value;
            }


            #exibir link para proxima pagina
            if ($this->_paginaAtual < ($this->_numeroDePaginas) && $this->_paginaAtual >= 1) {
                $nPage = $this->_paginaAtual + 1;
                $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;
                $urlLast = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . ($this->_numeroDePaginas);
                $html .= "<li class='next'>";
                $html .= "<a href='{$url}'><i class='icon-next'></i></a>";
                $html .= "</li>";
                $html .= "<li class='last'>";
                $html .= "<a href='{$urlLast}'><i class='icon-last-2'></i></a>";
                $html .= "</li>";
            } else {
                $html .= "<li class='disabled'><a><i class='icon-next'></i></a></li>";
                $html .= "<li class='disabled'><a><i class='icon-last-2'></i></a></li>";
            }
        }

        $html .= "<ul>";
        $html.= "</div>";

        $html.= "<div style='float:right;color:gray;'>";
        $html .= "Página {$this->_paginaAtual} de {$this->_numeroDePaginas}";
        $html.= "</div>";

        $html.= "<div style='clear: both;'></div>";
        $html.= "</div>";

        return $html;
    }

    private function addPage($nPage) {

        $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;

        #add o link da pagina ao array linkPage[]
        if ($this->_paginaAtual != $nPage) {
            $linkPage = "<li>
                            <a href='{$url}'>{$nPage}</a >
                        </li>";
        } else {
            $linkPage = "<li class='active'><a>{$nPage}</a></li>";
        }

        $this->_linkPage[] = $linkPage;
    }

}

?>