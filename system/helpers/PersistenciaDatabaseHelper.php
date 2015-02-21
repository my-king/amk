<?php

class PersistenciaDatabaseHelper {

    public static function isDatabase() {
        $isDatabase = is_file(DB_PERSISTENCIA);
        if ($isDatabase) {
            $database = simplexml_load_file(DB_PERSISTENCIA);
            return (isset($database->persistencia)) ? true : false;
        } else {
            return false;
        }
    }

    public static function getDatabase() {
        if (PersistenciaDatabaseHelper::isDatabase()) {
            return simplexml_load_file(DB_PERSISTENCIA);
        } else {
            return false;
        }
    }

    public static function addPesistenciaFromDatabase($name, $alias, $mask = false) {
        $xml = PersistenciaDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
            $sistema = $xml->addChild('persistencia');
            $sistema->addAttribute('name', $name);
            $sistema->addAttribute('alias', $alias);
            if($mask){
                $sistema->addAttribute('mask', 'true');
            }
            $xml->asXML(DB_PERSISTENCIA);
            return true;
        }
    }

    public static function removePersistenciaFromDatabase($name) {
        $xml = PersistenciaDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
            $i = 0;
            $return = false;
            foreach ($xml as $persistencia) {
                if ((string) $persistencia->attributes()->name === $name) {
                    unset($xml->persistencia[$i]);
                    $return = true;
                    break;
                }
                $i++;
            }
            $xml->asXML(DB_PERSISTENCIA);
            return $return;
        }
    }

    public static function isPersistenciaFromDatabase($name) {
        $xml = PersistenciaDatabaseHelper::getDatabase();
        if (!$xml) {
            return false;
        } else {
            foreach ($xml as $persistencia) {
                if ((string) $persistencia->attributes()->name === $name) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function listSelectArrayPersistence() {
        $xml = PersistenciaDatabaseHelper::getDatabase();
        if (!$xml) {
            return array();
        } else {
            $arrayPersistence = array();
            foreach ($xml as $persistencia) {
                $arrayPersistence[] = array('value' => (string) $persistencia->attributes()->name, 'descricao' => (string) $persistencia->attributes()->alias );
            }
            return $arrayPersistence;
        }
    }

    public static function listSelectArrayMask() {
        $xml = PersistenciaDatabaseHelper::getDatabase();
        if (!$xml) {
            return array();
        } else {
            $arrayMask = array();
            foreach ($xml as $persistencia) {
                if(isset($persistencia->attributes()->mask)){
                    $arrayMask[] = array('value' => (string) $persistencia->attributes()->name, 'descricao' => (string) $persistencia->attributes()->alias );
                }
            }
            return $arrayMask;
        }
    }

}
