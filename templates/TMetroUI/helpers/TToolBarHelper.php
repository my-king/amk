<?php

/**
 * @package HELPERS 
 */
class TToolBarHelper {

    public static $mapButtons = null;
    public static $validate = null;

    public static function configMapButton() {
        self::$mapButtons = array(
            'novo' => array('name' => 'Novo', 'icon' => 'icon-new', 'action' => 'cadastrar'),
            'editar' => array('name' => 'Editar', 'icon' => 'icon-copy', 'action' => 'editar', 'param' => 'id'),
            'resgatar' => array('name' => 'Resgatar', 'icon' => 'icon-cloud-2', 'action' => 'resgatar'),
            'excluir' => array('name' => 'Excluir', 'icon' => 'icon-remove', 'action' => 'deletar'),
            'reordenar' => array('name' => 'Reordenar', 'icon' => 'icon-loop', 'action' => 'reordenar'),
            'filtrar' => array('name' => 'Filtrar', 'icon' => 'icon-filter', 'action' => '#'),
            'imprimir' => array('name' => 'Imprimir', 'icon' => 'icon-printer', 'action' => 'imprimir'),
            'publicar' => array('name' => 'Publicar', 'icon' => 'icon-broadcast', 'action' => 'publicar'),
            'editarMunicipios' => array('name' => 'Editar Municipio', 'icon' => 'icon-github-6', 'action' => 'editarMunicipios', 'param' => 'id'),
            'remanejarVagasMunicipio' => array('name' => 'Remanejar Vagas', 'icon' => 'icon-tab', 'action' => 'remanejarVagasMunicipio', 'param' => 'id'),
            'editarLocal' => array('name' => 'Editar Mun Polo', 'icon' => 'icon-earth', 'action' => 'editarLocal', 'param' => 'id'),
            'editarQuantidadeVagas' => array('name' => 'Editar Vagas', 'icon' => 'icon-pie', 'action' => 'editarQuantidadeVagas', 'param' => 'id'),
            'listarAulas' => array('name' => 'Reg de Frequência', 'icon' => 'icon-clipboard-2', 'action' => 'listarAulas', 'param' => 'id'),
            'finalizarMatricula' => array('name' => 'Finalizar Matricula', 'icon' => 'icon-flag', 'action' => 'finalizarMatricula', 'param' => 'id'),
            'finalizarTurma' => array('name' => 'Finalizar Turma', 'icon' => 'icon-flag-2', 'action' => 'finalizarTurma', 'param' => 'id'),
            'excluirTurma' => array('name' => 'Excluir Turma', 'icon' => 'icon-cancel-2', 'action' => 'excluir', 'param' => 'id')
        );
    }

    public static function getValidate($toolbar) {
        $isToolbarAllow = SecurityHelper::getInstancia()->getUsuario()->isToolbarAllow($toolbar);
        if (self::$validate === null && $isToolbarAllow === true) {
            return true;
        } elseif ($isToolbarAllow === true && is_array(self::$validate)) {
            if (isset(self::$validate[$toolbar])) {
                return (self::$validate[$toolbar] === true) ? true : false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function getToolbar(Array $valid = null) {

        /* Configurar o mapeamento do button */
        self::configMapButton();
        self::$validate = ($valid !== null) ? $valid : null;

        /* Pecorrer mapButtons */
        $htmlToolBar = '';
        foreach (self::$mapButtons as $toolbar => $config) {

            if (self::getValidate($toolbar)) {
                $param = (isset($config['param'])) ? "/{$config['param']}/" . CurrentUrlHelper::getParam($config['param']) : '';
                $link = ($config['action'] !== '#') ? 'index.php?' . CurrentUrlHelper::getController() . "/{$config['action']}{$param}" : '#';
                $htmlToolBar .= "<a href='{$link}' id='tb_{$toolbar}'>
                                    <button class=\"shortcut\" >          
                                        <i class='{$config['icon']} fg-gray'></i>
                                        <span class='fg-gray'>{$config['name']}</span>
                                    </button>
                                </a>";
            }
        }

        $htmlToolBar = ($htmlToolBar !== '') ? "<div class='toolbar'>{$htmlToolBar}</div>" : '';
        return $htmlToolBar;
    }

}