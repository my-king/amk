<?php

class EntityLogic {

    public function atualizar($solicitante, $params) {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $entity = TObjetoHtmlHelper::mountEstruturaClassHtml($_POST);
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getEntity();
            ExportFileHelper::criarArquivo($path_entity . $_POST['objeto'] . ".php", $entity);
            unset($entity, $path_entity);

            TFeedbackHelper::notifySuccess("A Entity [ {$_POST['objeto']} ] foi atualizada com sucesso!!!");
            RedirectorHelper::addUrlParameter('file', $params['file']);
            RedirectorHelper::goToControllerAction($solicitante->modulo, $solicitante->page);
        } else {
            TFeedbackHelper::notifyWarning('Ocorreu um error na requisição, acesse corretamente.');
            RedirectorHelper::goToController('Principal');
        }
    }

    public function cadastrar($solicitante, $params) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $entity = TObjetoHtmlHelper::mountEstruturaClassHtml($_POST);
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getEntity();
            ExportFileHelper::criarArquivo($path_entity . $_POST['objeto'] . ".php", $entity);
            TFeedbackHelper::notifySuccess("A Entity [ {$_POST['objeto']} ] foi cadastrada com sucesso!!!");
            unset($entity, $path_entity);

            if (isset($_POST['dao'])) {
                $path_Dao = SecurityHelper::getInstancia()->getSistema()->getDao();
                $Dao = TObjetoHtmlHelper::mountClassDao($_POST['objeto']);
                ExportFileHelper::criarArquivo($path_Dao . $_POST['objeto'] . "DAO.php", $Dao);
                TFeedbackHelper::notifySuccess("A Dao [ {$_POST['objeto']}DAO ] foi cadastrada com sucesso!!!");
                unset($path_Dao, $Dao);
            }

            if (isset($_POST['logic'])) {
                $path_Logic = SecurityHelper::getInstancia()->getSistema()->getLogic();
                $Logic = TObjetoHtmlHelper::mountClassLogic($_POST['objeto']);
                ExportFileHelper::criarArquivo($path_Logic . $_POST['objeto'] . "Logic.php", $Logic);
                TFeedbackHelper::notifySuccess("A Logic [ {$_POST['objeto']}Logic ] foi cadastrada com sucesso!!!");
                unset($Logic, $path_Logic);
            }

            RedirectorHelper::addUrlParameter('file', $_POST['objeto']);
            RedirectorHelper::goToControllerAction($solicitante->modulo, 'editar');
        } else {
            TFeedbackHelper::notifyWarning('Ocorreu um error na requisição, acesse corretamente.');
            RedirectorHelper::goToController('Principal');
        }
    }

}
