<?php

class DatabaseLogic {

    private $xml;

    public function __construct() {
        $this->xml = simplexml_load_file(PATH_BASE_XML);
    }

    public function salvar($requisitante, $params = null) {

        if ($_SERVER['REQUEST_METHOD'] === "POST" && $requisitante->modulo === 'Administrator') {

            function isValid() {
                if ($_POST['projeto'] !== '' && $_POST['repositorio'] !== '' && $_POST['path'] !== '') {
                    return !DatabaseLogic::isSistemaFromDatabase($_POST['projeto']);
                } else {
                    return false;
                }
            }

            if (isValid()) {
                DatabaseLogic::addSistemaFromDatabase($_POST['projeto'], $_POST['repositorio'], $_POST['path']);
                RedirectorHelper::addUrlParameter('cad', 'ok');
                RedirectorHelper::goToController('Administrator');
            } else {
                RedirectorHelper::addUrlParameter('cad', 'error');
                RedirectorHelper::goToController('Administrator');
            }
        } else {
            RedirectorHelper::addUrlParameter('cad', 'error');
            RedirectorHelper::goToController('Administrator');
        }
    }

    public static function isDatabase() {
        $isDatabase = is_file(PATH_BASE_XML);
        if ($isDatabase) {
            $database = simplexml_load_file(PATH_BASE_XML);
            return (isset($database->sistema)) ? true : false;
        } else {
            return false;
        }
    }

    public static function getDatabase() {
        if (DatabaseLogic::isDatabase()) {
            return simplexml_load_file(PATH_BASE_XML);
        } else {
            return false;
        }
    }

    public static function addSistemaFromDatabase($name, $repositorio, $path_repositorio) {
        $xml = simplexml_load_file(PATH_BASE_XML);
        $sistema = $xml->addChild('sistema');
        $sistema->addAttribute('name', $name);
        $sistema->addAttribute('repositorio', $repositorio);
        $sistema->addChild('path', $path_repositorio);
        $xml->asXML(PATH_BASE_XML);
    }

    public function ajaxExcluirSistemaFromDatabase($params) {

        if (isset($params['name'])) {
            $deletar = DatabaseLogic::removeSistemaFromDatabase($params['name']);
            if ($deletar) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public static function removeSistemaFromDatabase($name) {
        $xml = simplexml_load_file(PATH_BASE_XML);
        $i = 0;
        $return = false;
        foreach ($xml as $key => $sistema) {
            if ((string) $sistema->attributes()->name === $name) {
                unset($xml->sistema[$i]);
                $return = true;
                break;
            }
            $i++;
        }
        $xml->asXML(PATH_BASE_XML);
        return $return;
    }

    public static function isSistemaFromDatabase($name) {

        $xml = simplexml_load_file(PATH_BASE_XML);
        foreach ($xml as $sistema) {
            if ((string) $sistema->attributes()->name === $name) {
                return true;
            }
        }

        return false;
    }

    public function listSistemas() {
        $arraySistemas = array();
        foreach ($this->xml as $sistema) {
            $obj = new stdClass();
            $obj->id = (string) $sistema->attributes()->repositorio;
            $obj->nome = (string) $sistema->attributes()->name;
            $arraySistemas[] = $obj;
            unset($obj);
        }
        return $arraySistemas;
    }

    public static function listPermitSistema() {
        $xml = simplexml_load_file(PATH_BASE_XML);
        $arraySistemas = array();
        foreach ($xml as $sistema) {
            $obj = new stdClass();
            $obj->id = (string) $sistema->attributes()->repositorio;
            $obj->nome = (string) $sistema->attributes()->name;
            $arraySistemas[] = $obj;
            unset($obj);
        }
        return $arraySistemas;
    }

}
