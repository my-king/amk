/* Lista de schemas */
SELECT DISTINCT schemaname AS "schema" FROM pg_catalog.pg_tables
WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
ORDER BY schemaname;

/* Lista de tabelas */
SELECT schemaname AS "schema" ,tablename AS "table" FROM pg_catalog.pg_tables
WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
ORDER BY schemaname, tablename;

/* Lista de views */
SELECT  schemaname AS "schema" ,viewname AS "view" FROM pg_catalog.pg_views
WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
ORDER BY schemaname,viewname;

/* retorna os campos com as propriedades passando schema e "nome da tabela ou view" como parâmetros */
SELECT 
	n.nspname AS schemaname, 
	c.relname AS objname,
	c.relkind AS objkind,
	a.attnum AS indexnum, 
	a.attname AS fieldname, 
	t.typname AS fieldtype, 
	a.atttypmod-4 as fieldlength, 
	NOT a.attnotnull AS "isnull", 
	d.adsrc AS defaultvalue 
FROM pg_attribute AS a
JOIN pg_class AS c ON c.oid=a.attrelid AND c.relname !~ '^pg_'
LEFT JOIN pg_namespace n ON n.oid = c.relnamespace 
JOIN pg_type AS t ON t.oid=a.atttypid
LEFT OUTER JOIN pg_attrdef AS d ON c.oid=d.adrelid AND 
d.adnum=a.attnum
WHERE a.attnum>0 AND n.nspname = 'schema' AND c.relname = 'tabela'
ORDER BY c.relkind, c.relname, a.attnum;