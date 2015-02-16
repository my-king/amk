<?php

class EntityHelper {

    private $reflection;
    private $propAtributos;
    private $colmaps;
    private $OneToMany;
    private $ManyToMany;

    public function __construct($class = null) {
        if($class !== null){
            $this->reflection = new ReflectionORM($class);
            $this->propAtributos = $this->reflection->getPropAtributos();
            $this->colmaps = $this->reflection->getAtributosFromColmap();
            $this->OneToMany = $this->reflection->getOneToMany();
            $this->ManyToMany = $this->reflection->getManyToMany();
        }
    }

    public function getNameClass() {
        return $this->reflection->getClass();
    }

    public function getSchema() {
        return $this->reflection->getClassAnnotations('@Schema');
    }

    public function getTable() {
        return $this->reflection->getClassAnnotations('@Table');
    }

    public function getColmaps() {

        $arrayColmap = array();
        if (isset($this->colmaps[0])) {
            foreach ($this->colmaps as $key => $atributo) {
                $arrayColmap[$key]['atributo'] = $atributo;
                $arrayColmap[$key]['colmap'] = $this->reflection->getPropAnnotations($atributo, "@Colmap");
                $arrayColmap[$key]['type'] = $this->getType($this->propAtributos[$atributo]);
                $arrayColmap[$key]['mask'] = $this->getMask($this->propAtributos[$atributo]);
                $arrayColmap[$key]['NotNull'] = $this->getNotNull($this->propAtributos[$atributo]);
                $arrayColmap[$key]['size'] = $this->getSize($this->propAtributos[$atributo]);
                $arrayColmap[$key]['MinSize'] = $this->getMinSize($this->propAtributos[$atributo]);
                $arrayColmap[$key]['MaxSize'] = $this->getMaxSize($this->propAtributos[$atributo]);
                $arrayColmap[$key]['OneToOne'] = $this->getOneToOne($this->propAtributos[$atributo]);
            }
        }

        return $arrayColmap;
    }

    
    private function getOneToOne(&$propriedades) {
        if (isset($propriedades['OneToOne']['objeto'])) {
            return $propriedades['OneToOne']['objeto'];
        } else {
            return '';
        }
    }

    public function getOneToMany() {
        $arrayOneToMany = array();
        $listOneToMany = $this->reflection->getOneToMany();
        if (isset($listOneToMany[0])) {
            foreach ($listOneToMany as $key => $atributo) {
                $OneToMany = $this->propAtributos[$atributo]['OneToMany'];
                $arrayOneToMany[$key]['atributo'] = $atributo;
                $arrayOneToMany[$key]['objeto'] = $OneToMany['objeto'];
                $arrayOneToMany[$key]['coluna'] = ( isset($OneToMany['coluna']) ) ? $OneToMany['coluna'] : '';
                unset($OneToMany);
            }
        }
        
        return $arrayOneToMany;
    }

    public function getManyToMany() {
        $arrayManyToMany = array();
        $listManyToMany = $this->reflection->getManyToMany();
        
        if (isset($listManyToMany[0])) {
            foreach ($listManyToMany as $key => $atributo) {
                $ManyToMany = $this->propAtributos[$atributo]['ManyToMany'];
                $arrayManyToMany[$key]['atributo'] = $atributo;
                $arrayManyToMany[$key]['objeto'] = $ManyToMany['objeto'];
                $arrayManyToMany[$key]['coluna'] = ( isset($ManyToMany['coluna']) ) ? $ManyToMany['coluna'] : '';
                $arrayManyToMany[$key]['schema'] = ( isset($ManyToMany['schema']) ) ? $ManyToMany['schema'] : '' ;
                $arrayManyToMany[$key]['table'] = $ManyToMany['table'];
                unset($ManyToMany);
            }
        }
        
        return $arrayManyToMany;
    }
    
    private function getType(&$propriedades) {
        if (isset($propriedades['Serial'])) {
            return 'Serial';
        } else {
            $persistence = (isset($propriedades['Persistence'])) ? $propriedades['Persistence'] : false;
            if (!$persistence) {
                return '';
            } else {
                return (isset($persistence->type)) ? $persistence->type : '';
            }
        }
    }

    private function getNotNull(&$propriedades) {
        $persistence = (isset($propriedades['Persistence'])) ? $propriedades['Persistence'] : false;
        if (!$persistence) {
            return 'YES';
        } else {
            return (!isset($persistence->NotNull)) ? 'YES' : 'NO';
        }
    }

    private function getSize(&$propriedades) {
        $persistence = (isset($propriedades['Persistence'])) ? $propriedades['Persistence'] : false;
        if (!$persistence) {
            return '';
        } else {
            return (isset($persistence->size)) ? $persistence->size : '';
        }
    }

    private function getMinSize(&$propriedades) {
        $persistence = (isset($propriedades['Persistence'])) ? $propriedades['Persistence'] : false;
        if (!$persistence) {
            return '';
        } else {
            return (isset($persistence->MinSize)) ? $persistence->MinSize : '';
        }
    }

    private function getMaxSize(&$propriedades) {
        $persistence = (isset($propriedades['Persistence'])) ? $propriedades['Persistence'] : false;
        if (!$persistence) {
            return '';
        } else {
            return (isset($persistence->MaxSize)) ? $persistence->MaxSize : '';
        }
    }

    private function getMask(&$propriedades) {
        if (isset($propriedades['Mask'])) {
            return $propriedades['Mask'];
        } else {
            return '';
        }
    }

    private function mountOption($array, $selected = '') {
        $optionHtml = '';
        foreach ($array as $key => $option) {
            $isSelected = ($selected === $option['value']) ? "selected=''" : '';
            $optionHtml .= "<option value='{$option['value']}' {$isSelected} >{$option['descricao']}</option>";
        }

        return $optionHtml;
    }

    public function selectType($selected = '') {

        $arrayType = array(
            0 => array('value' => '', 'descricao' => ''),
            1 => array('value' => 'Serial', 'descricao' => 'Serial'),
            2 => array('value' => 'inteiro', 'descricao' => 'Inteiro'),
            3 => array('value' => 'monetario', 'descricao' => 'Monetario'),
            4 => array('value' => 'decimal', 'descricao' => 'Decimal'),
            5 => array('value' => 'data', 'descricao' => 'Data'),
            6 => array('value' => 'hora', 'descricao' => 'Hora'),
            7 => array('value' => 'texto', 'descricao' => 'Texto'),
            8 => array('value' => 'email', 'descricao' => 'E-mail'),
            9 => array('value' => 'senha', 'descricao' => 'Senha'),
            10 => array('value' => 'cpf', 'descricao' => 'CPF'),
            11 => array('value' => 'cnpj', 'descricao' => 'CNPJ'),
            12 => array('value' => 'telefone', 'descricao' => 'Telefone'),
            13 => array('value' => 'cep', 'descricao' => 'CEP')
        );

        return $this->mountOption($arrayType, $selected);
    }

    public function selectMask($selected = '') {

        $arrayMask = array(
            0 => array('value' => '', 'descricao' => 'S/Mascara'),
            1 => array('value' => 'cpf', 'descricao' => 'CPF'),
            2 => array('value' => 'cnpj', 'descricao' => 'CNPJ'),
            3 => array('value' => 'data', 'descricao' => 'Data'),
            4 => array('value' => 'hora', 'descricao' => 'Hora'),
            5 => array('value' => 'telefone', 'descricao' => 'Telefone'),
            6 => array('value' => 'monetario', 'descricao' => 'Monetario')
        );

        return $this->mountOption($arrayMask, $selected);
    }

    public function selectNotNull($selected = '') {
        $arrayNotNull = array(
            0 => array('value' => 'YES', 'descricao' => 'NotNull ( false )'),
            1 => array('value' => 'NO', 'descricao' => 'NotNull ( true )')
        );

        return $this->mountOption($arrayNotNull, $selected);
    }

    public function selectObjectEntity($selected = '') {

        $listEntity = ExploreFileHelper::listarArquivos(SecurityHelper::getInstancia()->getSistema()->getEntity());
        $listVEntity = ExploreFileHelper::listarArquivos(SecurityHelper::getInstancia()->getSistema()->getVEntity());
        $joinList = array_merge($listEntity, $listVEntity);
        sort($joinList);
        unset($listEntity, $listVEntity);

        $arrayObjeto = array();
        $arrayObjeto[] = array('value' => '', 'descricao' => '');
        foreach ($joinList as $entity) {
            $arrayObjeto[] = array('value' => $entity, 'descricao' => $entity);
        }

        return $this->mountOption($arrayObjeto, $selected);
    }

}
