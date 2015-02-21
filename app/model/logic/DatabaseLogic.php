<?php

class DatabaseLogic {

    public function salvarProjeto($requisitante, $params = null) {

        if ($_SERVER['REQUEST_METHOD'] === "POST" && $requisitante->modulo === 'Administrator') {

            function isValid() {
                if ($_POST['projeto'] !== '' && $_POST['repositorio'] !== '' && $_POST['path'] !== '') {
                    return !ProjetoDatabaseHelper::isSistemaFromDatabase($_POST['projeto']);
                } else {
                    return false;
                }
            }

            if (isValid()) {
                $result = ProjetoDatabaseHelper::addSistemaFromDatabase($_POST['projeto'], $_POST['repositorio'], $_POST['path']);
                ($result) ? SessionHelper::setSession('cad_sucesso', 'true') : SessionHelper::setSession('cad_error', 'false');
                RedirectorHelper::goToController('Administrator');
            } else {
                SessionHelper::setSession('cad_error', 'false');
                RedirectorHelper::goToController('Administrator');
            }
        } else {
            SessionHelper::setSession('cad_error', 'false');
            RedirectorHelper::goToController('Administrator');
        }
    }

    public function ajaxExcluirSistemaFromDatabase($params) {

        if (isset($params['name'])) {
            $deletar = ProjetoDatabaseHelper::removeSistemaFromDatabase($params['name']);
            if ($deletar) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function salvarPersistencia($requisitante, $params = null) {

        if ($_SERVER['REQUEST_METHOD'] === "POST" && $requisitante->modulo === 'Administrator') {

            function isValid() {
                if ($_POST['persistencia'] !== '') {
                    return !PersistenciaDatabaseHelper::isPersistenciaFromDatabase($_POST['persistencia']);
                } else {
                    return false;
                }
            }

            if (isValid()) {
                $result = PersistenciaDatabaseHelper::addPesistenciaFromDatabase(
                    $_POST['persistencia'],
                    ($_POST['alias'] !== '') ? $_POST['alias'] : ucfirst($_POST['persistencia']),
                    (isset($_POST['mask'])) ? true : false 
                );
                ($result) ? SessionHelper::setSession('cad_sucesso', 'true') : SessionHelper::setSession('cad_error', 'false');
                RedirectorHelper::goToControllerAction('Administrator', 'persistencia');
            } else {
                SessionHelper::setSession('cad_error', 'false');
                RedirectorHelper::goToControllerAction('Administrator', 'persistencia');
            }
        } else {
            SessionHelper::setSession('cad_error', 'false');
            RedirectorHelper::goToControllerAction('Administrator', 'persistencia');
        }
    }

    public function ajaxExcluirPersistenciaFromDatabase($params) {
        if (isset($params['name'])) {
            $deletar = PersistenciaDatabaseHelper::removePersistenciaFromDatabase($params['name']);
            if ($deletar) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

}
