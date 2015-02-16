<?php

class VEntityLogic {

    public function atualizar($solicitante, $params) {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $entity = TObjetoHtmlHelper::mountEstruturaClassHtml($_POST);
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getVEntity();
            ExportFileHelper::criarArquivo($path_entity . $_POST['objeto'] . ".php", $entity);
            unset($entity, $path_entity);

            TFeedbackHelper::notifySuccess("A VEntity [ {$_POST['objeto']} ] foi atualizada com sucesso!!!");
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
            $path_entity = SecurityHelper::getInstancia()->getSistema()->getVEntity();
            ExportFileHelper::criarArquivo($path_entity . $_POST['objeto'] . ".php", $entity);
            TFeedbackHelper::notifySuccess("A VEntity [ {$_POST['objeto']} ] foi cadastrada com sucesso!!!");
            unset($entity, $path_entity);
            
            if (isset($_POST['VDao'])) {
                $path_vDao = SecurityHelper::getInstancia()->getSistema()->getVDao();
                $vDao = TObjetoHtmlHelper::mountClassVDao($_POST['objeto']);
                ExportFileHelper::criarArquivo($path_vDao . $_POST['objeto'] . "DAO.php", $vDao);
                TFeedbackHelper::notifySuccess("A VDao [ {$_POST['objeto']}DAO ] foi cadastrada com sucesso!!!");
                unset($path_vDao,$vDao);
            }

            if (isset($_POST['VLogic'])) {
                $path_VLogic = SecurityHelper::getInstancia()->getSistema()->getVLogic();
                $VLogic = TObjetoHtmlHelper::mountClassVLogic($_POST['objeto']);
                ExportFileHelper::criarArquivo($path_VLogic . $_POST['objeto'] . "Logic.php", $VLogic);
                TFeedbackHelper::notifySuccess("A VLogic [ {$_POST['objeto']}Logic ] foi cadastrada com sucesso!!!");
                unset($VLogic,$path_VLogic);
            }

            RedirectorHelper::addUrlParameter('file', $_POST['objeto']);
            RedirectorHelper::goToControllerAction($solicitante->modulo, 'editar');
            
        } else {
            TFeedbackHelper::notifyWarning('Ocorreu um error na requisição, acesse corretamente.');
            RedirectorHelper::goToController('Principal');
        }
    }

}
