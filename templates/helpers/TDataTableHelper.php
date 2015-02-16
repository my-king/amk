<?php

/**
 * Description of AjaxHelper
 * @author igor
 */
class TDataTableHelper {

    public static function mountOrderBy(array & $atributos, $position, $orderby) {

        $order = null;
        if (isset($atributos[$position])) {
            $order = $atributos[$position] . ':' . $orderby;
        }

        return $order;
    }
    
    public static function mountSearch(array & $colunas, $search, $and = true) {
        if ($search !== '') {
            $search = utf8_decode($search);
            function getInit($key, $value, &$search) {
                if (is_array($value)) {
                    $arrayQuery = array();
                    $pesquisa = strtolower($search);
                    $flagInit = true;
                    foreach ($value as $k => $val) {
                        $localizar = strpos(strtolower($val), $pesquisa);
                        if ($localizar !== false) {
                            if ($flagInit) {
                                $arrayQuery[] = "CAST({$key} AS TEXT) iLike '%{$k}%'";
                                $flagInit = false;
                            } else {
                                $arrayQuery[] = "OR CAST({$key} AS TEXT) iLike '%{$k}%'";
                            }
                        }
                        unset($localizar);
                    }
                    $query = (isset($arrayQuery[0])) ? implode(' ', $arrayQuery) : '';
                    unset($arrayQuery);
                    unset($flagInit);
                    unset($pesquisa);
                    return $query;
                } else {
                    return "CAST({$value} AS TEXT) iLike '%{$search}%'";
                }
            }

            function getOr($key, $value, &$search) {
                if (is_array($value)) {
                    $arrayQuery = array();
                    $pesquisa = strtolower($search);
                    foreach ($value as $k => $val) {
                        $localizar = strpos(strtolower($val), $pesquisa);
                        if ($localizar !== false) {
                            $arrayQuery[] = "OR CAST({$key} AS TEXT) iLike '%{$k}%'";
                        }
                        unset($localizar);
                    }
                    $query = (isset($arrayQuery[0])) ? implode(' ', $arrayQuery) : '';
                    unset($arrayQuery);
                    unset($pesquisa);
                    return $query;
                } else {
                    return "OR CAST({$value} AS TEXT) iLike '%{$search}%'";
                }
            }

            $flag = true;
            $arraySearch = array();
            $arraySearch[] = ($and === true) ? 'AND (' : '(';
            foreach ($colunas as $key => $value) {
                if ($flag) {
                    $flag = false;
                    $arraySearch[] = getInit($key, $value, $search);
                } else {
                    $or = getOr($key, $value, $search);
                    ($or !== '') ? $arraySearch[] = $or : '';
                    unset($or);
                }
            }
            $arraySearch[] = ")";
            $querySearch = implode(' ', $arraySearch);
            return $querySearch;
        } else {
            return ($and === true) ? '' : null;
        }
    }

    public static function mountArrayOutPut($sEcho, $iTotal) {
        
        $output = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );

        return $output;
    }

}