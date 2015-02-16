<?php

class SecurityHelper {

    private $sistema;
    private static $instancia = null;
    private $seguranca;

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new SecurityHelper();
        }
        return self::$instancia;
    }

    public function __clone() {
        trigger_error('Clone não é permitido.', E_USER_ERROR);
    }

    public function SecurityHelper() {
        if (!isset($_SESSION))
            session_start();

        $this->seguranca = $this->getDadosSeguranca();

        if ($this->isLogon()) {
            if (!isset($_SESSION['time_session'])) {
                $_SESSION['time_session'] = time() + (60 * 60 * 2);
                $this->sistema = unserialize($_SESSION[$this->seguranca['sessao']]);
            } else {
                if ($_SESSION['time_session'] > time()) {
                    $_SESSION['time_session'] = time() + (60 * 60 * 2);
                    $this->sistema = unserialize($_SESSION[$this->seguranca['sessao']]);
                } else {
                    unset($_SESSION['time_session']);
                    $this->destruirSessao();
                    RedirectorHelper::goToIndex();
                }
            }
        } else {
            $flag = (
                    stripos($_SERVER['QUERY_STRING'], 'Security/') === 0 ||
                    stripos($_SERVER['QUERY_STRING'], 'Index/logon') === 0
                    ) ? true : false;

            if (!$flag) {
                RedirectorHelper::goToControllerAction('Index', 'logon');
            }
        }
    }

    public function iniciarSessao(SistemaSecurity &$objSistema) {
        //session_register($this->seguranca['sessao']);
        $_SESSION[$this->seguranca['sessao']] = serialize($objSistema);
    }

    public function destruirSessao() {
        //session_unregister($this->seguranca['sessao']);
        unset($_SESSION[$this->seguranca['sessao']]);
        $this->seguranca['sessao'] = null;
    }

    private function getDadosSeguranca() {
        $ini = parse_ini_file('system/config/config.ini', true);
        return $ini['seguranca'];
    }

    public function getSistema() {
        return $this->sistema;
    }

    private function isLogon() {
        return (isset($_SESSION[$this->seguranca['sessao']])) ? true : false;
    }
}