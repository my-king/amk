<?php

class TEntityHtmlHelper {

    public static function mountHtml($propriedades, $key) {
        $conteudoFieldset = TEntityHtmlHelper::mountTableHtmlPropriedadesColmap($propriedades,$key);
        $conteudoFieldset .= TEntityHtmlHelper::mountTableHtmlPropriedades($propriedades,$key);
        $conteudoFieldset .= TEntityHtmlHelper::mountTableHtmlPropriedadesOneToOne($propriedades,$key);
        return TEntityHtmlHelper::mountHtmlFieldset($propriedades['coluna'], $conteudoFieldset);
    }
    
    public static function mountHtmlFieldset($colmap, $conteudo) {
        $fieldset = "<fieldset>";
        $fieldset .= "<legend class='fg-green'>Colmap ( {$colmap} )</legend>";
        $fieldset .= $conteudo;
        $fieldset .= "</fieldset>";
        $fieldset .= "<br />";
        $fieldset .= "<br />";
        return $fieldset;
    }
    
    public static function mountTableHtmlPropriedadesColmap(&$propriedades,$key) {
        
        $tablePropriedades = TEntityHtmlHelper::mountHtmlColmap($propriedades['coluna'],$key);        
        $tablePropriedades .= "<table width='100%'>";

            $tablePropriedades .= "<thead>";
                $tablePropriedades .= '<th class="text-left">Atributo</th>';
            $tablePropriedades .= "</thead>";

            $tablePropriedades .= "<tbody>";

                $tablePropriedades .= "<tr>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlNomeAtributo($propriedades['coluna'],$key);
                    $tablePropriedades .= "</td>";

                $tablePropriedades .= "</tr>";

            $tablePropriedades .= "</tbody>";

        $tablePropriedades .= "</table>";
        
        return $tablePropriedades;
    }
    
    public static function mountTableHtmlPropriedades(&$propriedades,$key) {
        
        $tablePropriedades = "<table  width='100%'>";

            $tablePropriedades .= "<thead>";
                $tablePropriedades .= '<th class="text-left size3">Type</th>';
                $tablePropriedades .= '<th class="text-left size2">Mask</th>';
                $tablePropriedades .= '<th class="text-left size2">NotNull</th>';
                $tablePropriedades .= '<th class="text-left size2">MinSize</th>';
                $tablePropriedades .= '<th class="text-left size2">MaxSize</th>';
                $tablePropriedades .= '<th class="text-left size2">Size</th>';
            $tablePropriedades .= "</thead>";

            $tablePropriedades .= "<tbody>";

                $tablePropriedades .= "<tr>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlType($propriedades, $key);
                    $tablePropriedades .= "</td>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlMask($key);
                    $tablePropriedades .= "</td>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlNotNull($propriedades['Nulo'], $key);
                    $tablePropriedades .= "</td>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlMinSize($key);
                    $tablePropriedades .= "</td>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlMaxSize($propriedades['MaxSize'],$key);
                    $tablePropriedades .= "</td>";

                    $tablePropriedades .= "<td>";
                        $tablePropriedades .= TEntityHtmlHelper::mountHtmlSize($key);
                    $tablePropriedades .= "</td>";

                $tablePropriedades .= "</tr>";

            $tablePropriedades .= "</tbody>";

        $tablePropriedades .= "</table>";
        
        return $tablePropriedades;
    }
    
    public static function mountTableHtmlPropriedadesOneToOne(&$propriedades,$key) {
        
        $tablePropriedadesOneToOne = '';    
        $tablePropriedadesOneToOne .= "<table width='100%'>";

            $tablePropriedadesOneToOne .= "<thead>";
                $tablePropriedadesOneToOne .= '<th class="text-left" >Relationship: OneToOne ( Objeto )</th>';
            $tablePropriedadesOneToOne .= "</thead>";

            $tablePropriedadesOneToOne .= "<tbody>";

                $tablePropriedadesOneToOne .= "<tr>";

                    $tablePropriedadesOneToOne .= "<td>";
                        $tablePropriedadesOneToOne .= TEntityHtmlHelper::mountHtmlRealcionamentoOneToOne($key);
                    $tablePropriedadesOneToOne .= "</td>";

                $tablePropriedadesOneToOne .= "</tr>";

            $tablePropriedadesOneToOne .= "</tbody>";

        $tablePropriedadesOneToOne .= "</table>";
        
        return $tablePropriedadesOneToOne;
    }    
    
    public static function mountHtmlRealcionamentoOneToOne($key) {
        $name = "dados[{$key}][OneToOne]";
        $atributo = '<div class="input-control text" data-role="input-control">';
            $atributo .= '<input type="text" name="'.$name.'" id="OneToOne" placeholder="Nome do Objeto Relacionado" />';
            $atributo .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
        $atributo .= '</div>';
        return $atributo;
    }

    public static function mountHtmlColmap($coluna,$key) {
        $name = "dados[{$key}][colmap]";
        $colmap = '<input type="hidden" name="'.$name.'" value="' . $coluna . '"/>';
        return $colmap;
    }

    public static function mountHtmlNomeAtributo($colmap,$key) {
        $atributoSugerido = GestaoORM::getAtributoSugerido($colmap);
        $name = "dados[{$key}][atributo]";
        $atributo = '<div class="input-control text" data-role="input-control">';
            $atributo .= '<input type="text" name="'.$name.'" id="atributo" placeholder="Nome do Atributo" value="'.$atributoSugerido.'" required/>';
            $atributo .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
        $atributo .= '</div>';
        return $atributo;
    }

    public static function mountHtmlType(&$propriedades, $key) {
        $name = "dados[{$key}][type]";
        $translateType = GestaoORM::translateType($propriedades);
        $id = "type{$key}";
        $htmlType = TEntityHtmlHelper::mountScriptSelect2($id, 'Defina o Type');
        $htmlType .= '<div class="input-control select">';
            $htmlType .= '<select name="'.$name.'" id="' . $id . '" required >';
                $htmlType .= '<option value="" ' . TEntityHtmlHelper::mountSelected('', $translateType) . '></option>';
                $htmlType .= '<option value="Serial" ' . TEntityHtmlHelper::mountSelected('Serial', $translateType) . '>Serial</option>';
                $htmlType .= '<option value="inteiro" ' . TEntityHtmlHelper::mountSelected('inteiro', $translateType) . '>Inteiro</option>';
                $htmlType .= '<option value="monetario" ' . TEntityHtmlHelper::mountSelected('monetario', $translateType) . '>Monetario</option>';
                $htmlType .= '<option value="decimal" ' . TEntityHtmlHelper::mountSelected('decimal', $translateType) . '>Decimal</option>';
                $htmlType .= '<option value="data" ' . TEntityHtmlHelper::mountSelected('data', $translateType) . '>Data</option>';
                $htmlType .= '<option value="hora" ' . TEntityHtmlHelper::mountSelected('hora', $translateType) . '>Hora</option>';
                $htmlType .= '<option value="texto" ' . TEntityHtmlHelper::mountSelected('texto', $translateType) . '>Texto</option>';
                $htmlType .= '<option value="email" ' . TEntityHtmlHelper::mountSelected('email', $translateType) . '>E-mail</option>';
                $htmlType .= '<option value="senha" ' . TEntityHtmlHelper::mountSelected('senha', $translateType) . '>Senha</option>';
                $htmlType .= '<option value="cpf" ' . TEntityHtmlHelper::mountSelected('cpf', $translateType) . '>CPF</option>';
                $htmlType .= '<option value="cnpj" ' . TEntityHtmlHelper::mountSelected('cnpj', $translateType) . '>CNPJ</option>';
                $htmlType .= '<option value="telefone" ' . TEntityHtmlHelper::mountSelected('telefone', $translateType) . '>Telefone</option>';
                $htmlType .= '<option value="cep" ' . TEntityHtmlHelper::mountSelected('cep', $translateType) . '>Codigo Postal (CEP)</option>';
            $htmlType .= '</select>';
        $htmlType .= '</div>';
        return $htmlType;
    }

    public static function mountHtmlMask($key) {
        $name = "dados[{$key}][mask]";
        $id = "mask{$key}";
        $htmlMask = TEntityHtmlHelper::mountScriptSelect2($id, 'Defina a mascara');
        $htmlMask .= '<div class="input-control select">';
            $htmlMask .= '<select name="'.$name.'" id="' . $id . '">';
                $htmlMask .= '<option value="" selected > S/Mascara</option>';
                $htmlMask .= '<option value="cpf" >CPF</option>';
                $htmlMask .= '<option value="cnpj" >CNPJ</option>';
                $htmlMask .= '<option value="data" >Data</option>';
                $htmlMask .= '<option value="hora" >Hora</option>';
                $htmlMask .= '<option value="telefone" >Telefone</option>';
            $htmlMask .= '</select>';
        $htmlMask .= '</div>';
        return $htmlMask;
    }

    public static function mountHtmlSize($key) {
        $name = "dados[{$key}][Size]";
        $htmlSize = '<div class="input-control text" data-role="input-control">';
            $htmlSize .= '<input type="text" name="'.$name.'" id="Size" placeholder="Size" />';
            $htmlSize .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
        $htmlSize .= '</div>';
        return $htmlSize;
    }
    
    public static function mountHtmlMinSize($key) {
        $name = "dados[{$key}][MinSize]";
        $htmlMinSize = '<div class="input-control text" data-role="input-control">';
            $htmlMinSize .= '<input type="text" name="'.$name.'" id="MinSize" placeholder="MinSize" />';
            $htmlMinSize .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
        $htmlMinSize .= '</div>';
        return $htmlMinSize;
    }
    
    public static function mountHtmlMaxSize($MaxSize = null,$key) {
        $name = "dados[{$key}][MaxSize]";
        $MaxSize = ($MaxSize !== null) ? $MaxSize : '';
        $htmlMaxSize = '<div class="input-control text" data-role="input-control">';
            $htmlMaxSize .= '<input type="text" name="'.$name.'" id="MaxSize" placeholder="MaxSize" value="' . $MaxSize . '"/>';
            $htmlMaxSize .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
        $htmlMaxSize .= '</div>';
        return $htmlMaxSize;
    }


    public static function mountHtmlNotNull($nulo, $key) {
        $name = "dados[{$key}][NotNull]";
        $id = "NotNull{$key}";
        $NotNull = TEntityHtmlHelper::mountScriptSelect2($id, 'Campo é Nulo?');
        $NotNull .= '<div class="input-control select">';
            $NotNull .= '<select name="'.$name.'" id="' . $id . '" required="">';
                $NotNull .= '<option value=""></option>';
                $NotNull .= '<option value="NO" ' . TEntityHtmlHelper::mountSelected('NO', $nulo) . '>NotNull ( true )</option>';
                $NotNull .= '<option value="YES" ' . TEntityHtmlHelper::mountSelected('YES', $nulo) . '>NotNull ( false )</option>';
            $NotNull .= '</select>';
        $NotNull .= '</div>';
        return $NotNull;
    }

    public static function mountSelected($option, $selected) {
        if ($selected === $option) {
            return 'selected';
        }
        return '';
    }

    public static function mountScriptSelect2($id, $placeholder) {
        $script = '<script>';
        $script .= '$(document).ready(function() {';
        $script .= '$("#' . $id . '").select2({placeholder:"' . $placeholder . '"});';
        $script .= '});';
        $script .= '</script>';
        return $script;
    }

}
