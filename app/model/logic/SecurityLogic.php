<?php

class SecurityLogic {

    public function logar($requisitante, $params) {

        $xml = simplexml_load_file(PATH_BASE_XML);
        $objXmlSistema = $xml->sistema;
        $tSistema = count($objXmlSistema);
        $sistema = (!CurrentUrlHelper::isParam('sistema')) ? $_POST['sistema'] : CurrentUrlHelper::getParam('sistema');

        if (isset($_SESSION)) {
            unset($_SESSION);
            RegistryORM::getInstancia()->defaultStorage();
        }

        if ($tSistema === 1) {

            $repositorio = (string) $objXmlSistema->attributes()->repositorio;

            /* Sistema é valido */
            if ($repositorio === $sistema) {

                $nome = (string) $objXmlSistema->attributes()->name;
                $path = (string) $objXmlSistema->path;
                $model = $path . 'app\model\\';
                $conexoes = ExploreFileHelper::listarArquivos($path . 'system\orm\dal\\');

                $sessionSystem = new SistemaSecurity();
                $sessionSystem->setNome($nome);
                $sessionSystem->setLogic($model . 'logic\\');
                $sessionSystem->setVLogic($model . 'logic\views\\');
                $sessionSystem->setDao($model . 'dao\\');
                $sessionSystem->setVDao($model . 'dao\views\\');
                $sessionSystem->setEntity($model . 'entity\\');
                $sessionSystem->setVEntity($model . 'entity\views\\');
                $sessionSystem->setConfig($path . 'system\config\config.ini');
                $sessionSystem->setConexoes($conexoes);

                $objSecurity = SecurityHelper::getInstancia();
                $objSecurity->iniciarSessao($sessionSystem);
                unset($sessionSystem);

                RedirectorHelper::goToController("Principal");
            } else {
                /* Não existe sistema mapeado */
                TFeedbackHelper::notifyWarning('Sistema escolhido é invalido');
                RedirectorHelper::goToControllerAction("Index", 'logon');
            }
        } elseif ($tSistema > 1) {

            $sessionOK = false;

            foreach ($objXmlSistema as $objSistema) {

                $repositorio = (string) $objSistema->attributes()->repositorio;
                $nome = (string) $objSistema->attributes()->name;

                /* Sistema é valido */
                if ($repositorio === $sistema) {

                    $path = (string) $objSistema->path;
                    $model = $path . 'app\model\\';
                    $conexoes = ExploreFileHelper::listarArquivos($path . 'system\orm\dal\\');

                    $sessionSystem = new SistemaSecurity();
                    $sessionSystem->setNome($nome);
                    $sessionSystem->setLogic($model . 'logic\\');
                    $sessionSystem->setVLogic($model . 'logic\views\\');
                    $sessionSystem->setDao($model . 'dao\\');
                    $sessionSystem->setVDao($model . 'dao\views\\');
                    $sessionSystem->setEntity($model . 'entity\\');
                    $sessionSystem->setVEntity($model . 'entity\views\\');
                    $sessionSystem->setConfig($path . 'system\config\config.ini');
                    $sessionSystem->setConexoes($conexoes);

                    $objSecurity = SecurityHelper::getInstancia();
                    $objSecurity->iniciarSessao($sessionSystem);
                    unset($sessionSystem);

                    $sessionOK = true;
                    break;
                }

                unset($nome, $repositorio);
            }

            if ($sessionOK) {
                RedirectorHelper::goToController("Principal");
            } else {
                /* Não existe sistema mapeado */
                TFeedbackHelper::notifyWarning('Sistema escolhido é invalido');
                RedirectorHelper::goToControllerAction("Index", 'logon');
            }
        } else {
            /* Não existe sistema mapeado */
            TFeedbackHelper::notifyWarning('Sistema escolhido é invalido');
            RedirectorHelper::goToControllerAction("Index", 'logon');
        }
    }

    public function deslogar() {
        SecurityHelper::getInstancia()->destruirSessao();
        RedirectorHelper::goToControllerAction("Index", 'logon');
    }

}
