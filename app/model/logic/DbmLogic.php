<?php

class DbmLogic {

    public function ajaxListSelect2SchemaFromDal($params) {
        $listSchema = DatabaseMarketingORM::listSchema($params['dal']);
        $array = false;
        if(isset($listSchema[0])){
            foreach ($listSchema as $dados) {
                $array[] = array('value' => utf8_encode($dados['schema']), 'nome' => utf8_encode($dados['schema']));
            }
        }
        return json_encode($array);
    }
    
    public function ajaxListSelect2TableFromSchema($params) {
        $listTable = DatabaseMarketingORM::listTableFromSchema($params['dal'],$params['schema']);
        $array = false;
        if(isset($listTable[0])){
            foreach ($listTable as $dados) {
                $array[] = array('value' => utf8_encode($dados['table']), 'nome' => utf8_encode($dados['table']));
            }
        }
        return json_encode($array);
    }

    public function ajaxListSelect2VTableFromSchema($params) {
        $listTable = DatabaseMarketingORM::listViewFromSchema($params['dal'],$params['schema']);
        $array = false;
        if(isset($listTable[0])){
            foreach ($listTable as $dados) {
                $array[] = array('value' => utf8_encode($dados['view']), 'nome' => utf8_encode($dados['view']));
            }
        }
        return json_encode($array);
    }

    public function ajaxListSelect2ColmapFromTable($params) {
        $listColmap = DatabaseMarketingORM::listColmaps($params['dal'],$params['schema'],$params['table']);
        $array = false;
        if(isset($listColmap[0])){
            foreach ($listColmap as $dados) {
                $array[] = array('value' => utf8_encode($dados['colmap']), 'nome' => utf8_encode($dados['colmap']));
            }
        }
        return json_encode($array);
    }

    public function listColmaps($dal,$schema,$table,$NotIn = null) {
        $listColmap = DatabaseMarketingORM::listColmaps($dal,$schema,$table);
        $arrayColmaps = false;
        if(isset($listColmap[0])){
            switch (DatabaseMarketingORM::getType($dal)) {
                case 'pgsql':
                    foreach ($listColmap as $dados) {
                        if($NotIn !== $dados['colmap']){
                            $objColmap = new stdClass();
                            $objColmap->colmap = $dados['colmap'];
                            $objColmap->type = ConvertORM::getType($dados['type']);
                            $objColmap->MaxSize = ConvertORM::getSize($dados['size']);
                            $objColmap->IsNull = (!$dados['isnull']) ? 'NO' : 'YES' ;
                            $arrayColmaps[] = $objColmap;
                        }
                    }
                    break;
                case 'mysql':
                    foreach ($listColmap as $dados) {
                        $arrayColmaps[] = '';
                    }
                    break;
            }
        }
        
        return $arrayColmaps;
    }
    
    public function ajaxIsColmaps($params) {
        $listColmap = DatabaseMarketingORM::listColmaps($params['dal'],$params['schema'],$params['table'],$params['colmaps']);        
        $result = (isset($listColmap[0])) ? true : false;
        return json_encode($result);
    }

    
    public function ajaxListColmaps($params) {
        $listColmap = DatabaseMarketingORM::listColmaps($params['dal'],$params['schema'],$params['table'],$params['colmaps']);
        
        $dados = false;
        if(isset($listColmap[0])){
            $dados = array();
            foreach ($listColmap as $key => $arrayColmap) {
                $dados[$key]['colmap'] = $arrayColmap['colmap'];
                $dados[$key]['type'] = ConvertORM::getType($arrayColmap['type']);
                $dados[$key]['MaxSize'] = ConvertORM::getSize($arrayColmap['size']);
                $dados[$key]['IsNull'] = (!$arrayColmap['colmap']) ? 'NO' : 'YES' ;
            }
            
        }
        
        return json_encode($dados);
        
    }
    
}
