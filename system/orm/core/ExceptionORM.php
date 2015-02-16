<?php

/**
 * Description of QueryHelper
 *
 * @author igor
 */
class ExceptionORM {

    /**
     * <p>Recebe os atributos a serem carregados pelo objeto e retorna um exeption 
     * com os campos que devem ser ignorados no carregamento do objeto</p>
     * @param Object|string $objeto Pode ser passado uma instancia do objeto ou o nome do mesmo
     * @param Array $atributos Passa um array de atributos que deseja carregar ou não carregar no objeto
     * @param bollean $load Padrão true onde os itens passados seram o carregado no objeto, caso false os itens seram ignorado no carregamento do objeto
     * @return array Retorna o array $exception com o array de atributos a serem ignorado
     */
    public static function mountLoadException($objeto, Array $atributos, $load = true) {

        $exception = array();
        $id = array_search('id', $atributos);

        if ($load) {

            if ($id === false) {
                $atributos[] = 'id';
            }

            $reflection = new ReflectionClass($objeto);
            unset($objeto);

            foreach ($reflection->getProperties() as $atributo) {
                $exception[$atributo->name] = false;
            }
            unset($reflection);

            /* Deletar atributos passados no array de atributos */
            foreach ($atributos as $value) {
                if (isset($exception[$value])) {
                    unset($exception[$value]);
                }
            }
        } else { /* Mapear atributos a não ser retornados no objeto */
            if ($id !== false) {
                unset($atributos[$id]);
            }
            foreach ($atributos as $value) {
                $exception[$value] = false;
            }
        }


        return $exception;
    }

}
