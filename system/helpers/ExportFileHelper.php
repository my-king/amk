<?php
class ExportFileHelper {

    public static function criarArquivo($alias , $conteudo , $modo = "w+") {
        $fp = fopen($alias, $modo);
        fwrite($fp, $conteudo);
        fclose($fp);
        unset($conteudo);
    }

}
