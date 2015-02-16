<?php

class RequestController extends TRequest {

    public function post() {
        $nameObjLogic = ucfirst($this->getParam('l')) . 'Logic';
        $method = $this->getParam('a');
        $HTTP_REFERER = ( is_string($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : '';
        $params = TPostHelper::mountParams($HTTP_REFERER);
        $ObjLogic = new $nameObjLogic();
        $ObjLogic->$method( TPostHelper::getFuncionalidadeFromUrl( $HTTP_REFERER ) , $params );
    }

    public function get() {
        $nameObjLogic = ucfirst($this->getParam('l')) . 'Logic';
        $method = $this->getParam('a');
        $ObjLogic = new $nameObjLogic();
        $params = $this->getParam();
        unset($params['a'],$params['l']);
        (count($params) > 0) ? $ObjLogic->$method($params) : $ObjLogic->$method();
    }

    /**
     * AjaxPost
     * O metodo recebe um $_POST e retorna um objeto json
     * @param string $_POST['dados']['objeto'] Nome do objeto a ser instanciado
     * @param string $_POST['dados']['method'] Nome do metodo a ser chamado sem o ajax
     * @param array $params Caso exista mais dados na variavel $_POST é alocado nesta variavel
     * @return objeto json
     */
    public function ajaxPost() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $POST = $_POST['dados'];
            unset($_POST);
            $nameObjLogic = ucfirst($POST['objeto']) . 'Logic';
            unset($POST['objeto']);

            $method = 'ajax' . ucfirst($POST['method']);
            unset($POST['method']);

            $tPost = count($POST);
            if ($tPost > 0) {
                $params = $POST;
            }
            unset($tPost);
            unset($POST);

            $ObjLogic = new $nameObjLogic();
            unset($nameObjLogic);

            if (!isset($params)) {
                $result = $ObjLogic->$method();
            } else {
                $result = $ObjLogic->$method($params);
            }
            unset($ObjLogic);
            unset($method);
            unset($params);

            echo $result;
        } else {
            echo false;
        }
    }

    /**
     * AjaxGet
     * O metodo recebe um $_GET e retorna um objeto json
     * @param string $_GET['objeto'] Nome do objeto a ser instanciado
     * @param string $_GET['method'] Nome do metodo a ser chamado sem o ajax
     * @param array $params Caso exista mais dados na variavel $_POST é alocado nesta variavel
     * @return objeto json
     */
    public function ajaxGet() {

        if ($_SERVER['REQUEST_METHOD'] === "GET") {

            unset($_GET['c']);
            unset($_GET['a']);

            $DADOS = $_GET;
            unset($_GET);
            $nameObjLogic = ucfirst($DADOS['objeto']) . 'Logic';
            unset($DADOS['objeto']);

            $method = 'ajax' . ucfirst($DADOS['method']);
            unset($DADOS['method']);

            $tGet = count($DADOS);
            if ($tGet > 0) {
                $params = $DADOS;
            }
            unset($tGet);
            unset($DADOS);

            $ObjLogic = new $nameObjLogic();
            unset($nameObjLogic);

            if (!isset($params)) {
                $result = $ObjLogic->$method();
            } else {
                $result = $ObjLogic->$method($params);
            }
            unset($ObjLogic);
            unset($method);
            unset($params);

            echo $result;
        } else {
            echo false;
        }
    }

    /**
     * AjaxSession
     * O metodo recebe um $_POST e criar uma session
     * @param string $_POST['dados']['session'] Nome do objeto a ser instanciado
     * @param string $_POST['dados']['value'] Nome do metodo a ser chamado sem o ajax
     * @param array $params Caso exista mais dados na variavel $_POST é alocado nesta variavel
     * @return objeto json
     */
    public function ajaxSession() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $_SESSION[$_POST['dados']['session']] = $_POST['dados']['value'];
            unset($_POST);
            echo 'true';
        } else {
            echo 'false';
        }
    }

}