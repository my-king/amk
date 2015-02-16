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

    public function __construct($totalRegistros, $pagina = null) {
        $this->setResultadoPorPagina(LIMIT);
        $this->_totalRegistros = $totalRegistros;
        $this->_numeroDePaginas = ceil($totalRegistros / $this->_resultadoPorPagina);
        $this->_paginaAtual = ($pagina != null) ? $pagina : 0;
        $this->_inicio = ($pagina != null) ? $this->_paginaAtual * $this->_resultadoPorPagina : 0;
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
        if ($this->_numeroDePaginas < 10) {
            $pagina['inicio'] = 0;
            $pagina['fim'] = $this->_numeroDePaginas - 1;
            return $pagina;
        } else {

            # Pagina incial
            $pageDif = $this->_numeroDePaginas - ($this->_paginaAtual + 1);
            
            switch ($pageDif) {
                case 3:
                    $pagina['inicio'] = $this->_paginaAtual - 6;
                    $pagina['fim'] = 9;
                    break;
                case 2:
                    $pagina['inicio'] = $this->_paginaAtual - 7;
                    $pagina['fim'] = 9;
                    break;
                case 1:
                    $pagina['inicio'] = $this->_paginaAtual - 8;
                    $pagina['fim'] = 9;
                    break;
                case 0:
                    $pagina['inicio'] = $this->_paginaAtual - 9;
                    $pagina['fim'] = 9;
                    break;
                default:
                    $pagina['inicio'] = ($this->_paginaAtual > 5) ? ($this->_paginaAtual - 5) : 0;
                    $pagina['fim'] = 9;
                    break;
            }


            return $pagina;
        }
    }

    public function getPaginacao() {

        $pagina = $this->getIntervaloDaPagina();
        $countLink = $pagina['inicio'];
        for ($i = 0; $i <= $pagina['fim']; $i++) {
            $this->addPage($countLink);
            $countLink++;
        }
        unset($countLink);

        $html = "<div id='paginacao'>";
            $html .= "<ul>";

                if ($this->_numeroDePaginas > 1) {

                    #exibir link para pagina anterior
                    if ($this->_paginaAtual > 0) {
                        $nPage = $this->_paginaAtual - 1;
                        $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;
                        $html .= "<li>";
                        $html .= "<a href='{$url}'>« Pagina Anterior</a>";
                        $html .= "</li>";
                    } else {
                        $html .= "<li class='nolink'>« Pagina Anterior</li>";
                    }
                    
                
                    #listar link das paginas
                    foreach ($this->_linkPage as $value) {
                          $html.= $value;
                    }
                  

                    #exibir link para proxima pagina
                    if ($this->_paginaAtual < ($this->_numeroDePaginas - 1) && $this->_paginaAtual >= 0) {
                        $nPage = $this->_paginaAtual + 1;
                        $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;
                        $html .= "<li>";
                        $html .= "<a href='{$url}'>Proxima Pagina »</a>";
                        $html .= "</li>";
                    } else {
                        $html .= "<li class='nolink'>Proxima Pagina »</li>";
                    }
                }

                    $numeroDaPagina = ($this->_numeroDePaginas == 0) ? 1 : $this->_numeroDePaginas - 1;
                    $html .= "<li class='npage'>Pagina {$this->_paginaAtual} de {$numeroDaPagina}</li>";

            $html .= "<ul>";
        $html.= "</div>";

        return $html;
    }

    private function addPage($nPage) {

        $url = PATH_URL . 'index.php?' . $this->getCurrentController() . '/' . $this->getCurrentAction() . '/page/' . $nPage;

        #add o link da pagina ao array linkPage[]
        if ($this->_paginaAtual != $nPage) {
            $linkPage = "<li>
                            <a href = '{$url}'>{$nPage}</a >
                        </li>";
        } else {
            $linkPage = "<li class='current'>
                               {$nPage}
                        </li>";
        }

        $this->_linkPage[] = $linkPage;
    }
    
        
}

?>