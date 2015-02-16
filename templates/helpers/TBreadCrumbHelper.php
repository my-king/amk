<?php

class TBreadCrumbHelper {

    public static function start() {

        $bredcrumb = TBreadCrumbHelper::load();

        if ($bredcrumb) {
            $html = '<br />';
            $html .= '<nav class="breadcrumbs mini">';
            $html .= '<ul>';

            $html .= '<li><a href="' . $bredcrumb[0]['url'] . '"><i class="icon-home"></i></a></li>';

            /* Calcular ultimo indice */
            $indActive = count($bredcrumb) - 1;
            $active = $bredcrumb[$indActive];
            unset($bredcrumb[0], $bredcrumb[$indActive]);

            if (count($bredcrumb) > 0) {
                foreach ($bredcrumb as $crumb) {
                    $html .= '<li><a href="' . $crumb['url'] . '">' . $crumb['name'] . '</a></li>';
                }
            }

            $html .= '<li class="active"><a href="#">' . $active['name'] . '</a></li>';
            unset($active);

            $html .= '</ul>';
            $html .= '</nav>';
            echo $html;
        }
        unset($bredcrumb);
    }

    public static function mountParams($params) {
        $paramsUrl = '';
        if (isset($params[0])) {
            foreach ($params as $param) {
                $paramsUrl .= '/';
                $paramsUrl .= $param->attributes()->name . '/' . CurrentUrlHelper::getParam("{$param->attributes()->param}");
            }
        }
        return $paramsUrl;
    }

    public static function load() {

        $controller = CurrentUrlHelper::getController();
        $page = CurrentUrlHelper::getAction();

        /* Carrega e armazena o XML na variavel $xml */
        $xml = simplexml_load_file(PATH_SYSTEM . 'config/bredcrumb.xml');

        /* Iniciar mapeamento */
        $bredcrumb = array();
        /* Home */
        $bredcrumb[] = array('name' => 'Home', 'url' => 'index.php?' . $xml->home->attributes()->module . '/' . $xml->home->attributes()->action);

        $module = $xml->xpath("//module[@name='{$controller}']");
        $module = (isset($module[0])) ? $module[0] : false;

        if ($module) {

            $path = 'index.php?' . $module->attributes()->name;

            $parent = ($module->attributes()->parent === null) ? false : $module->attributes()->parent;
            if ($parent) {
                $parentName = ($module->attributes()->parentName === null) ? (string) $module->attributes()->parent : (string) $module->attributes()->parentName;
                $bredcrumb[] = array('name' => $parentName, 'url' => 'index.php?' . $module->attributes()->parent);
            }
            
            $main = ($module->attributes()->main === null) ? false : $module->attributes()->main;
            if ($main) {
                $bredcrumb[] = array('name' => "{$module->attributes()->name}", 'url' => 'index.php?' . $module->attributes()->name . '/' . $main);
            } else {
                $bredcrumb[] = array('name' => "{$module->attributes()->name}", 'url' => '#');
            }

            $loadXmlModule = simplexml_load_string($module->asXML());
            $action = $loadXmlModule->xpath("//action[@name='{$page}']");
            $action = (isset($action[0])) ? $action[0] : false;

            if ($action) {

                if (isset($action->crumb[0])) {
                    foreach ($action->crumb as $crumb) {
                        $bredcrumb[] = array(
                            'name' => "{$crumb->attributes()->name}",
                            'url' => 'index.php?' . $module->attributes()->name . '/' . $crumb->attributes()->action . TBreadCrumbHelper::mountParams($crumb->params)
                        );
                    }
                }
                
                $nameAction = ($action->attributes()->alias === null) ? $action->attributes()->name : $action->attributes()->alias  ;
                $bredcrumb[] = array(
                    'name' => "{$nameAction}",
                    'url' => 'index.php?' . $module->attributes()->name . '/' . $action->attributes()->name
                );
            } else {
                return false;
            }

            return $bredcrumb;
        } else {
            return false;
        }
    }

}
