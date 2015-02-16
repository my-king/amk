<?php

class DatabaseLogic {

    private $xml;

    public function __construct() {
        $this->xml = simplexml_load_file(PATH_BASE_XML);
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
