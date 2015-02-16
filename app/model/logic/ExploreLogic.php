<?php

class ExploreLogic {

    public function ajaxListEntity($params) {

        $search = ($params['sSearch'] !== '') ? $params['sSearch'] : null;
        $listArquivos = ExploreFileHelper::listarArquivos(
                        SecurityHelper::getInstancia()->getSistema()->getEntity(), $search
        );
        $arrayList = ExploreFileHelper::mountArrayFilePagination(
                        $listArquivos, $params['iDisplayStart'], $params['iDisplayLength']
        );

        /* Total de registros */
        $iTotal = count($listArquivos);

        /* Montar output */
        $output = TDataTableHelper::mountArrayOutPut($params['sEcho'], $iTotal);
        unset($iTotal);

        if (isset($arrayList[0])) {
            foreach ($arrayList as $file) {
                $link = "<a href='index.php?Entity/editar/file/{$file}'>{$file}</a>";
                $output['aaData'][] = array(
                    utf8_encode($link)
                );
                unset($link);
            }
        }
        unset($arrayList);

        return json_encode($output);
    }

    public function ajaxListVEntity($params) {

        $search = ($params['sSearch'] !== '') ? $params['sSearch'] : null;
        $listArquivos = ExploreFileHelper::listarArquivos(
                        SecurityHelper::getInstancia()->getSistema()->getVEntity(), $search
        );
        
        $arrayList = ExploreFileHelper::mountArrayFilePagination(
                        $listArquivos, $params['iDisplayStart'], $params['iDisplayLength']
        );
        /* Total de registros */
        $iTotal = count($listArquivos);

        /* Montar output */
        $output = TDataTableHelper::mountArrayOutPut($params['sEcho'], $iTotal);
        unset($iTotal);

        if (isset($arrayList[0])) {
            foreach ($arrayList as $file) {
                $link = "<a href='index.php?VEntity/editar/file/{$file}'>{$file}</a>";
                $output['aaData'][] = array(
                    utf8_encode($link)
                );
            }
        }
        unset($arrayList);

        return json_encode($output);
    }

    public function ajaxListDao($params) {

        $search = ($params['sSearch'] !== '') ? $params['sSearch'] : null;
        $listArquivos = ExploreFileHelper::listarArquivos(
                        SecurityHelper::getInstancia()->getSistema()->getDao(), $search
        );
        $arrayList = ExploreFileHelper::mountArrayFilePagination(
                        $listArquivos, $params['iDisplayStart'], $params['iDisplayLength']
        );

        /* Total de registros */
        $iTotal = count($listArquivos);

        /* Montar output */
        $output = TDataTableHelper::mountArrayOutPut($params['sEcho'], $iTotal);
        unset($iTotal);

        if (isset($arrayList[0])) {
            foreach ($arrayList as $file) {
                //$link = "<a href='index.php?Entidade/informar/id/{$object->getId()}'>{$object->getNome()}</a>";
                $output['aaData'][] = array(
                    utf8_encode($file)
                );
            }
        }
        unset($arrayList);

        return json_encode($output);
    }

    public function ajaxListLogic($params) {

        $search = ($params['sSearch'] !== '') ? $params['sSearch'] : null;
        $listArquivos = ExploreFileHelper::listarArquivos(
                        SecurityHelper::getInstancia()->getSistema()->getLogic(), $search
        );
        $arrayList = ExploreFileHelper::mountArrayFilePagination(
                        $listArquivos, $params['iDisplayStart'], $params['iDisplayLength']
        );

        /* Total de registros */
        $iTotal = count($listArquivos);

        /* Montar output */
        $output = TDataTableHelper::mountArrayOutPut($params['sEcho'], $iTotal);
        unset($iTotal);

        if (isset($arrayList[0])) {
            foreach ($arrayList as $file) {
                //$link = "<a href='index.php?Entidade/informar/id/{$object->getId()}'>{$object->getNome()}</a>";
                $output['aaData'][] = array(
                    utf8_encode($file)
                );
            }
        }
        unset($arrayList);

        return json_encode($output);
    }

}
