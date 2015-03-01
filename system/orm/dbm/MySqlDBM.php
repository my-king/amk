<?php

class MySqlDBM {

    public function listSchema() {
        return "SELECT DISTINCT TABLE_SCHEMA AS 'schema' FROM information_schema.TABLES";
    }

    public function listTableFromSchema($schema) {
        return "SELECT TABLE_NAME AS 'table' FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$schema}' ORDER BY TABLE_NAME";
    }

    public function listColmaps($schema, $table, Array $NOT_IN = null) {

        $NOT_COLMAPS = ($NOT_IN === null) ? '' : "AND COLUMN_NAME NOT IN ('" . implode("','", $NOT_IN) . "') ";
        $query = "SELECT "
                . "COLUMN_NAME AS 'colmap', "
                . "DATA_TYPE AS 'type', "
                . "CHARACTER_MAXIMUM_LENGTH AS 'size', "
                . "IS_NULLABLE AS 'isnull', "
                . "COLUMN_KEY AS 'Chave', "
                . "EXTRA "
                . "FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA = '" . $schema . "' AND TABLE_NAME = '{$table}' {$NOT_COLMAPS} ORDER BY COLUMN_NAME";
                
        return $query;
    }

}
