<?php

class PgSqlDBM {
    public function listSchema() {
        return "SELECT DISTINCT schemaname AS schema FROM pg_catalog.pg_tables
                    WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
                    ORDER BY schemaname";
    }

    public function listTableFromSchema($schema) {
        return "SELECT
                    tablename AS \"table\" 
                FROM pg_catalog.pg_tables
                    WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
                        AND schemaname = '{$schema}'
                ORDER BY schemaname, tablename";
    }

    public function listViewFromSchema($schema) {
        return "SELECT
                    viewname AS \"view\" 
                FROM pg_catalog.pg_views
                    WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
                        AND schemaname = '{$schema}'
                ORDER BY schemaname,viewname";
    }

    public function listColmaps($schema,$table, Array $NOT_IN = null) {
        
        $NOT_COLMAPS = ($NOT_IN === null) ? '' : "AND a.attname NOT IN ('". implode("','", $NOT_IN) ."') ";
        return "SELECT 
                    n.nspname AS schema, 
                    c.relname AS table,
                    a.attname AS colmap, 
                    t.typname AS type, 
                    a.atttypmod-4 as size, 
                    NOT a.attnotnull AS \"isnull\", 
                    d.adsrc AS defaultvalue 
                FROM pg_attribute AS a
                    JOIN pg_class AS c ON c.oid=a.attrelid AND c.relname !~ '^pg_'
                    LEFT JOIN pg_namespace n ON n.oid = c.relnamespace 
                    JOIN pg_type AS t ON t.oid=a.atttypid
                    LEFT OUTER JOIN pg_attrdef AS d ON c.oid=d.adrelid AND d.adnum=a.attnum
                WHERE a.attnum>0 AND n.nspname = '{$schema}' AND c.relname = '{$table}' {$NOT_COLMAPS}
                ORDER BY c.relkind, c.relname, a.attnum;";
    }
}