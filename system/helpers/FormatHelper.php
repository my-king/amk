<?php

/**
 * Class responsavel por formatações
 * @author Igor da Hora <igordahora@gmail.com>
 */
class FormatHelper {
    /**
     * Obtem o nome sugerido pelo sistema atravez do atributo passado
     * @param type $colmap
     * @return type $atributo
     */
    public static function getAtributoSugerido($colmap) {
        $arrayColmap = explode('_', $colmap);
        $atributo = $arrayColmap[0];
        unset($arrayColmap[0]);
        $tArray = count($arrayColmap);
        if ($tArray > 0) {
            foreach ($arrayColmap as $value) {
                $atributo .= ucfirst($value);
            }
        }
        return $atributo;
    }

}
