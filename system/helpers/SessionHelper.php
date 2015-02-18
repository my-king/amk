<?php

class SessionHelper {

    /**
     * Iniciar session
     */
    public static function start() {
        if (!isset($_SESSION)){
            session_start();
        }
    }
    
    /**
     * Obter valor de um item da session
     * @param type $nome
     * @return type
     */
    public static function getSession($nome){
        SessionHelper::start();
        return (isset($_SESSION[$nome])) ? $_SESSION[$nome] : false;
    }

    /**
     * Adicionar item a session
     * @param type $nome
     * @param type $value
     */
    public static function setSession($nome,$value){
        SessionHelper::start();
        $_SESSION[$nome] = $value;
    }

    /**
     * Deletar um item da session
     * @param type $nome
     */
    public static function deleteSession($nome){
        SessionHelper::start();
        if(isset($_SESSION[$nome])){
            unset($_SESSION[$nome]);
        }
    }
}
