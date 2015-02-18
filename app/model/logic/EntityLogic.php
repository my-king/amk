<?php

class EntityLogic {

    public function atualizar($solicitante, $params) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $objeto = ucfirst($_POST['objeto']);
            $entity = TObjetoHtmlHelper::mountEstruturaClassHtml($_POST);
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getEntity();
            ExportFileHelper::criarArquivo($path_entity . $objeto . ".php", $entity);
            unset($entity, $path_entity);

            TFeedbackHelper::notifySuccess("A Entity [ {$objeto} ] foi atualizada com sucesso!!!");
            RedirectorHelper::addUrlParameter('file', $params['file']);
            RedirectorHelper::goToControllerAction($solicitante->modulo, $solicitante->page);
        } else {
            TFeedbackHelper::notifyWarning('Ocorreu um error na requisição, acesse corretamente.');
            RedirectorHelper::goToController('Principal');
        }
    }

    public function cadastrar($solicitante, $params) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $objeto = ucfirst($_POST['objeto']);
            $entity = TObjetoHtmlHelper::mountEstruturaClassHtml($_POST);
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getEntity();
            ExportFileHelper::criarArquivo($path_entity . $objeto . ".php", $entity);
            TFeedbackHelper::notifySuccess("A Entity [ {$objeto} ] foi cadastrada com sucesso!!!");
            unset($entity, $path_entity);

            if (isset($_POST['dao'])) {
                $path_Dao = SecurityHelper::getInstancia()->getSistema()->getDao();
                $Dao = TObjetoHtmlHelper::mountClassDao($objeto);
                ExportFileHelper::criarArquivo($path_Dao . $objeto . "DAO.php", $Dao);
                TFeedbackHelper::notifySuccess("A Dao [ {$objeto}DAO ] foi cadastrada com sucesso!!!");
                unset($path_Dao, $Dao);
            }

            if (isset($_POST['logic'])) {
                $path_Logic = SecurityHelper::getInstancia()->getSistema()->getLogic();
                $Logic = TObjetoHtmlHelper::mountClassLogic($objeto);
                ExportFileHelper::criarArquivo($path_Logic . $objeto . "Logic.php", $Logic);
                TFeedbackHelper::notifySuccess("A Logic [ {$objeto}Logic ] foi cadastrada com sucesso!!!");
                unset($Logic, $path_Logic);
            }

            RedirectorHelper::addUrlParameter('file', $objeto);
            RedirectorHelper::goToControllerAction($solicitante->modulo, 'editar');
        } else {
            TFeedbackHelper::notifyWarning('Ocorreu um error na requisição, acesse corretamente.');
            RedirectorHelper::goToController('Principal');
        }
    }

}
