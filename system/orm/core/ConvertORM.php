<?php

class ConvertORM {
    public static function getType($type) {
        
        $arrayType = array(
          'int4' => 'inteiro',  
          'varchar' => 'texto',  
          'bpchar' => 'texto',  
          'text' => 'texto',
          'numeric' => 'monetario'
        );
        
        return (isset($arrayType[$type])) ? $arrayType[$type] : '';
    }

    public static function getSize($size) {
        return ($size > 0) ? $size : '' ;
    }
}
