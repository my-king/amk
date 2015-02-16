<?php

/**
 * Criação de url dinamicas para requisição
 * @author igor
 */
class UrlRequestHelper {

    public static function mountUrlPost($logic, $action, Array $params = null) {
        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $dados[] = $key;
                $dados[] = $value;
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }
        return "index.php?Request/post/l/{$logic}/a/{$action}{$param}";
    }

    public static function mountUrlGet($logic, $action, Array $params = null) {
        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $dados[] = $key;
                $dados[] = $value;
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }
        return "index.php?Request/get/l/{$logic}/a/{$action}{$param}";
    }

    public static function mountUrl($controller, $action, Array $params = null) {

        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $valor = str_replace(' ', '-', $value);
                $dados[] = $key;
                $dados[] = $valor;
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }

        return "index.php?" . ucfirst($controller) . "/{$action}{$param}";
    }

}
