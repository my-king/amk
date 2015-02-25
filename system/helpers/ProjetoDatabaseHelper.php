<?php

class ProjetoDatabaseHelper {

    public static function isDatabase() {
        $isDatabase = is_file(DB_PROJETOS);
        if ($isDatabase) {
            $database = simplexml_load_file(DB_PROJETOS);
            return (isset($database->sistema)) ? true : false;
        } else {
            return false;
        }
    }

    public static function getDatabase() {
        return simplexml_load_file(DB_PROJETOS);
    }

    public static function addSistemaFromDatabase($name, $repositorio, $path_repositorio) {
        if (!is_file(DB_PROJETOS)) {
            return false;
        } else {
            $xml = ProjetoDatabaseHelper::getDatabase();
            $sistema = $xml->addChild('sistema');
            $sistema->addAttribute('name', $name);
            $sistema->addAttribute('repositorio', $repositorio);
            if (ProjetoDatabaseHelper::isBarra($path_repositorio)) {
                $sistema->addChild('path', $path_repositorio);
            } else {
                $sistema->addChild('path', $path_repositorio.'/');
            }
            $xml->asXML(DB_PROJETOS);
            return true;
        }
    }

    public static function removeSistemaFromDatabase($name) {
        $xml = ProjetoDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
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
            $xml->asXML(DB_PROJETOS);
            return $return;
        }
    }

    public static function isSistemaFromDatabase($name) {

        $xml = ProjetoDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
            foreach ($xml as $sistema) {
                if ((string) $sistema->attributes()->name === $name) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function listSistemas() {
        $xml = ProjetoDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
            $arraySistemas = array();
            foreach (ProjetoDatabaseHelper::getDatabase() as $sistema) {
                $obj = new stdClass();
                $obj->id = (string) $sistema->attributes()->repositorio;
                $obj->nome = (string) $sistema->attributes()->name;
                $arraySistemas[] = $obj;
                unset($obj);
            }
            return $arraySistemas;
        }
    }

    public static function listPermitSistema() {
        $xml = simplexml_load_file(DB_PROJETOS);
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

    public static function isBarra($path) {
        if (substr($path, strlen($path) - 1) === "/") {
            return true;
        } else {
            return false;
        }
    }

}
