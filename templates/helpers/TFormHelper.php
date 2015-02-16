<?php

/**
 * Description of TFormHelper
 * Altomatiza elementos de formularios
 * @author igor
 */
class TFormHelper {

    /**
     * Passa uma colleciton de objetos e retorna um select simples
     * @param type $collection
     */
    public static function select($atributo, $collection, $selected = "") {

        $select = "<select name='{$atributo}'>";
        $select .= "<option value=''>Selecione</option>";

        foreach ($collection as $obj) {
            if ($selected != "") {
                $selected = ($selected == $obj->getId()) ? "selected" : "";
                $select .= "<option value='{$obj->getId()}' {$selected}>{$obj->getNome()}</option>";
            } else {
                $select .= "<option value='{$obj->getId()}'>{$obj->getNome()}</option>";
            }
        }

        $select .= "</select>";

        return $select;
    }

    /**
     * Passa uma colleciton de objetos e retorna um select multiple
     * @param type $collection
     * @param type $selected
     */
    public static function selectMultiple($collection) {
        $select = "<select multiple>";
        foreach ($collection as $obj) {
            $select .= "<option value='{$obj->getId()}'>{$obj->getNome()}</option>";
        }
        $select .= "</select>";
    }

    /**
     * 
     * @param array $lista = null
     * @param type $value = nome
     * @param type $idSelected = null
     * @param string $codigo = id
     * @return string option
     */
    public static function optionSelect(array $lista = null, $value = 'nome', $idSelected = null, $codigo = 'id') {

        $options = null;
        $method = "get" . ucfirst($value);
        $codigo = 'get' . ucfirst($codigo);

        if ($lista !== null) {
            $countLista = count($lista);
            if ($countLista > 0) {

                if ($idSelected !== null) {
                    foreach ($lista as $objeto) {
                        $selected = ($idSelected == $objeto->$codigo()) ? 'selected' : '';
                        $options.="<option value='{$objeto->$codigo()}' {$selected} >{$objeto->$method()}</option>";
                    }
                } else {
                    foreach ($lista as $objeto) {
                        $options.="<option value='{$objeto->$codigo()}'>{$objeto->$method()}</option>";
                    }
                }
            }
            unset($countLista);
        }

        return $options;
    }

    public static function optionSelectObject(array $lista, $id, $nome, $descricao = null) {

        $options = null;
        if ($lista != null) {
            foreach ($lista as $objeto) {
                $getDescricao = ($descricao === null) ? '' : ' ('.$objeto->$descricao.')';
                $options.="<option value='{$objeto->$id}'>{$objeto->$nome}{$getDescricao}</option>"; unset($getDescricao);
            }
        }

        return $options;
    }

    public static function optionSelectArray(array $lista = null) {
        $options = null;

        if ($lista !== null) {
            foreach ($lista as $array) {
                $options.="<option value='{$array['id']}'>{$array['descricao']}</option>";
            }
        }

        return $options;
    }

    public static function optionSelectArrayIndice(array $lista = null) {
        $options = null;

        if ($lista !== null) {
            foreach ($lista as $id => $descricao) {

                $options.="<option value='{$id}'>{$descricao}</option>";
            }
        }

        return $options;
    }

}

?>