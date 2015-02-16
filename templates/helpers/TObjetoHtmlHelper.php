<?php

class TObjetoHtmlHelper {
    
    public static function enter($n = 1){
            $enter = '';
            for ($i = 0; $i < $n; $i++) {
                $enter .= chr(13).chr(10);
            }
            
            return $enter;
    }

    public static function tab($n = 1){
        $tab = '';
        for ($i = 0; $i < $n; $i++) {
            $tab .= chr(32).chr(32).chr(32).chr(32);
        }
        return $tab;
    }

    public static function mountEstruturaClassHtml($dados) {
        $atributos = array();
        $conteudo = '';
        foreach ($dados['dados'] as $propriedades) {
            $atributos[] = $propriedades['atributo'];
            $conteudo.= TObjetoHtmlHelper::mountAtributos($propriedades);
        }
        
        if(isset($dados['OneToMany'])){
            foreach ($dados['OneToMany'] as $propriedades) {
                $atributos[] = $propriedades['atributo'];
                $conteudo.= TObjetoHtmlHelper::relationshipOneToMany($propriedades);
            }
        }
        
        if(isset($dados['ManyToMany'])){
            foreach ($dados['ManyToMany'] as $propriedades) {
                $atributos[] = $propriedades['atributo'];
                $conteudo.= TObjetoHtmlHelper::relationshipManyToMany($propriedades);
            }
        }
        
        foreach ($atributos as $value) {
            $conteudo .= TObjetoHtmlHelper::mountGetAndSet($value);
        }
        
        return TObjetoHtmlHelper::mountClassEntity($dados['table'],$dados['schema'],$dados['objeto'],$conteudo);
    }
    
    public static function mountClassEntity($tabela, $schema, $nomeClass, $conteudo = null) {
        $html = "<?php".TObjetoHtmlHelper::enter(2);
        $html .= "/**".TObjetoHtmlHelper::enter();
        $html .= "* @Table = " . $tabela . TObjetoHtmlHelper::enter();
        $html .= ($schema === '') ? '' : "* @Schema = " . $schema . TObjetoHtmlHelper::enter();
        $html .= "*/". TObjetoHtmlHelper::enter();
        $html .= "class {$nomeClass} {".TObjetoHtmlHelper::enter(2);
        $html .= $conteudo;
        $html .= "}";
        return $html;
    }

    public static function mountClassDao($nomeClass) {
        $html = "<?php\n\n";
        $html .= "class {$nomeClass}DAO extends DaoModel {\n\n";
            $html .= TObjetoHtmlHelper::tab()."public function __construct() {".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab(2)."parent::__construct(\"{$nomeClass}\");".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        $html .= "}";
        return $html;
    }

    public static function mountClassVDao($nomeClass) {
        $html = "<?php\n\n";
        $html .= "class {$nomeClass}DAO extends VDaoModel {\n\n";
            $html .= TObjetoHtmlHelper::tab()."public function __construct() {".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab(2)."parent::__construct(\"{$nomeClass}\");".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        $html .= "}";
        return $html;
    }

    public static function mountClassLogic($nomeClass) {
        $html = "<?php\n\n";
        $html .= "class {$nomeClass}Logic extends LogicModel {".TObjetoHtmlHelper::enter(2);
            $html .= TObjetoHtmlHelper::tab()."public function __construct() {".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab(2)."parent::__construct(new {$nomeClass}DAO());".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        $html .= "}";
        return $html;
    }

    public static function mountClassVLogic($nomeClass) {
        $html = "<?php\n\n";
        $html .= "class {$nomeClass}Logic extends VLogicModel {".TObjetoHtmlHelper::enter(2);
            $html .= TObjetoHtmlHelper::tab()."public function __construct() {".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab(2)."parent::__construct(new {$nomeClass}DAO());".TObjetoHtmlHelper::enter();
            $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        $html .= "}";
        return $html;
    }

    public static function mountAtributos(&$propriedades) {
        $html = TObjetoHtmlHelper::tab()."/**".TObjetoHtmlHelper::enter();
        $html .= ($propriedades['atributo'] === 'id') ? TObjetoHtmlHelper::serial($propriedades['type']) : '';
        $html .= TObjetoHtmlHelper::tab()."* @Colmap = {$propriedades['colmap']}".TObjetoHtmlHelper::enter();
        $html .= ($propriedades['atributo'] !== 'id') ? TObjetoHtmlHelper::mask($propriedades['mask']) : '';
        $html .= TObjetoHtmlHelper::persistence($propriedades);
        $html .= TObjetoHtmlHelper::relationshipOneToOne((isset($propriedades['OneToOne'])) ? $propriedades['OneToOne'] : '');
        $html .= TObjetoHtmlHelper::tab()."*/".TObjetoHtmlHelper::enter();
        $html .= TObjetoHtmlHelper::tab()."private \${$propriedades['atributo']};".TObjetoHtmlHelper::enter(2);
        return $html;
    }

    public static function mask($mask = null) {
        $html = ($mask !== '') ? TObjetoHtmlHelper::tab()."* @Mask = {$mask}".TObjetoHtmlHelper::enter() : '';
        return $html;
    }
    public static function persistence(&$propriedades) {
        $html = '';
        if($propriedades['type'] !== 'Serial'){
            
            $persistencia = array();
            $persistencia[] = "type={$propriedades['type']}";
            
            if(isset($propriedades['NotNull'])){
                $persistencia[] = ($propriedades['NotNull'] === 'NO') ? 'NotNull=true':'';
            }
            
            if(isset($propriedades['MinSize'])){
                $persistencia[] = ($propriedades['MinSize'] !== '') ? "MinSize={$propriedades['MinSize']}":'';
            }
            
            if(isset($propriedades['MaxSize'])){
                $persistencia[] = ($propriedades['MaxSize'] !== '') ? "MaxSize={$propriedades['MaxSize']}":'';
            }
            
            if( isset($propriedades['MaxSize']) && isset($propriedades['MaxSize']) && isset($propriedades['MinSize']) ){
                $persistencia[] = ($propriedades['size'] !== '' && ($propriedades['MaxSize'] === '' && $propriedades['MinSize'] === '')) ? "size={$propriedades['size']}":'';
            }
            
            foreach ($persistencia as $key => $value) {
                if($value === ''){
                    unset($persistencia[$key]);
                }
            }
            
            $persistence = implode(',', $persistencia);
            unset($persistencia);
            $html .= TObjetoHtmlHelper::tab()."* @Persistence ({$persistence})\n";
            unset($persistence);
        }
        
        return $html;
    }
    
    public static function serial($type) {
        $serial = '';
        if($type === 'Serial'){
            $serial = TObjetoHtmlHelper::tab()."* @Serial".TObjetoHtmlHelper::enter();
        }
        return $serial;
    }
    
    public static function mountGetAndSet($atributo) {
        
        $get = 'get'.ucfirst($atributo);
        $set = 'set'.ucfirst($atributo);
        /* GET */
        $html = TObjetoHtmlHelper::tab()."public function {$get}() {".TObjetoHtmlHelper::enter();
        $html .= TObjetoHtmlHelper::tab(2)."return \$this->{$atributo};".TObjetoHtmlHelper::enter();
        $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        
        /* SET */
        $html .= TObjetoHtmlHelper::tab()."public function {$set}(\${$atributo}) {".TObjetoHtmlHelper::enter();
        $html .= TObjetoHtmlHelper::tab(2)."\$this->{$atributo} = \${$atributo};".TObjetoHtmlHelper::enter();
        $html .= TObjetoHtmlHelper::tab()."}".TObjetoHtmlHelper::enter(2);
        
        return $html;
    }

    public static function relationshipOneToOne($objeto) {
        $relationship = '';
        if($objeto !== ''){
            $relationship = TObjetoHtmlHelper::tab()."* @Relationship (objeto={$objeto},type=OneToOne)".TObjetoHtmlHelper::enter();
        }
        return $relationship;
    }

    public static function relationshipOneToMany($propriedades) {
        $coluna = ($propriedades['coluna'] === '') ? '' : ",coluna={$propriedades['coluna']}" ;
        $relationship = TObjetoHtmlHelper::tab()."/**".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."* @Relationship (objeto={$propriedades['objeto']},type=OneToMany{$coluna})".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."*/".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."private \${$propriedades['atributo']};".TObjetoHtmlHelper::enter(2);
        unset($coluna);
        return $relationship;
    }

    public static function relationshipManyToMany($propriedades) {
        $coluna = ($propriedades['coluna'] === '') ? '' : ",coluna={$propriedades['coluna']}" ;
        $schema = ($propriedades['schema'] === '') ? '' : ",schema={$propriedades['schema']}" ;
        $relationship = TObjetoHtmlHelper::tab()."/**".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."* @Relationship (objeto={$propriedades['objeto']},type=ManyToMany{$schema},table={$propriedades['table']}{$coluna})".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."*/".TObjetoHtmlHelper::enter();
        $relationship .= TObjetoHtmlHelper::tab()."private \${$propriedades['atributo']};".TObjetoHtmlHelper::enter(2);
        unset($coluna);
        return $relationship;
    }
}
