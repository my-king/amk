<?php

/**
 * Description of ExploreHelper
 *
 * @author igorsantos
 */
class ExploreFileHelper {

    private static $instancia = null;

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new ExploreFileHelper();
        }
        return self::$instancia;
    }

    public function __clone() {
        trigger_error('Clone não é permitido.', E_USER_ERROR);
    }

    public static function listarArquivos($dir, $search = null) {

        if (!is_dir($dir) || $dir == "") {
            return false;
        }

        $ponteiro = opendir($dir);

        $arquivos = array();
        $itens = array();
        // monta os vetores com os itens encontrados na pasta
        while ($nome_itens = readdir($ponteiro)) {
            $itens[] = $nome_itens;
        }

        // ordena o vetor de itens
        sort($itens);

        // percorre o vetor para fazer a separacao entre arquivos e pastas 
        foreach ($itens as $arquivo) {
            // retira "./" e "../" para que retorne apenas pastas e arquivos
            if ($arquivo !== '.' && $arquivo !== '..' && $arquivo !== 'index.html') {
                // checa se o tipo de arquivo encontrado é uma pasta
                if (!is_dir($dir . $arquivo)) {
                    // caso FALSO adiciona o item à variável de arquivos
                    if ($search !== null) {
                        if (strripos($arquivo, $search) !== false) {
                            $arquivos[] = $arquivo;
                        }
                    } else {
                        $arquivos[] = $arquivo;
                    }
                }
            }
        }

        // lista os arquivos se houverem
        if (isset($arquivos[0])) {
            foreach ($arquivos as $key => $value) {
                $arquivos[$key] = substr($value, 0, -4);
            }
        }
        
        return $arquivos;
    }

    public static function criarArquivo($alias, $conteudo, $modo = "w+") {
        $fp = fopen($alias, $modo);
        fwrite($fp, $conteudo);
        // Fecha o arquivo
        fclose($fp);
        unset($conteudo);
    }

    public static function mountArrayFilePagination(Array $arrayFiles, $inicio, $total) {

        $arquivos = array();
        if (isset($arrayFiles[0])) {
            $t = 0;
            foreach ($arrayFiles as $key => $file) {
                if ($key >= $inicio && $t < $total) {
                    $arquivos[] = $file;
                    $t++;
                }
                if ($t === $total) {
                    break;
                }
            }
        }

        return $arquivos;
    }

}
