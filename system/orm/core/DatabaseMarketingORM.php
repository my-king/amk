<?php

class DatabaseMarketingORM {

    public static $conn = null;
    public static $dbm = null;

    public static function connect($DAL) {

        if (DatabaseMarketingORM::$conn === null) {

            $config = parse_ini_file(SecurityHelper::getInstancia()->getSistema()->getConfig(), true);
            $conexao = $config[$DAL];
            unset($config);
            /* Inicia a instancia de resgistro de banco de dados */
            $registry = RegistryORM::getInstancia();

            /* Criar objeto com dados para conexão */
            $classConn = new stdClass();
            $classConn->type = $conexao['type'];
            $classConn->server = $conexao['server'];
            switch ($classConn->type) {
                case 'pgsql':
                    $classConn->port = ( isset($conexao['port']) ) ? $conexao['port'] : 5432;
                    DatabaseMarketingORM::$dbm = new PgSqlDBM();
                    break;
                case 'mysql':
                    $classConn->port = ( isset($conexao['port']) ) ? $conexao['port'] : 3306;
                    DatabaseMarketingORM::$dbm = new MySqlDBM();
                    break;
                default:
                    break;
            }
            $classConn->database = $conexao['database'];
            $classConn->user = $conexao['user'];
            $classConn->password = $conexao['password'];

            /* Criar registro da conexão */
            $registry->set($DAL, $classConn);
            unset($conexao, $classConn);
            DatabaseMarketingORM::$conn = $registry->get($DAL);
        }
    }

    public static function getType($DAL) {
            $config = parse_ini_file(SecurityHelper::getInstancia()->getSistema()->getConfig(), true);
            $type = $config[$DAL]['type'];
            unset($config);
            return $type;
    }

    public static function listSchema($DAL) {
        /* Faz conexão do o banco */
        DatabaseMarketingORM::connect($DAL);
        $query = DatabaseMarketingORM::$dbm->listSchema();
        try {
            $prepare = DatabaseMarketingORM::$conn->prepare($query);
            $prepare->execute();
            $prepare->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $prepare->fetchAll();
            return $rows;
        } catch (Exception $e) {
            LogErroORM::gerarLogSelect($e->getMessage(), $query);
            return false;
        }
    }

    public static function listTableFromSchema($DAL, $schema) {
        /* Faz conexão do o banco */
        DatabaseMarketingORM::connect($DAL);
        $query = DatabaseMarketingORM::$dbm->listTableFromSchema($schema);
        try {
            $prepare = DatabaseMarketingORM::$conn->prepare($query);
            $prepare->execute();
            $prepare->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $prepare->fetchAll();
            return $rows;
        } catch (Exception $e) {
            LogErroORM::gerarLogSelect($e->getMessage(), $query);
            return false;
        }
    }

    public static function listViewFromSchema($DAL, $schema) {
        /* Faz conexão do o banco */
        DatabaseMarketingORM::connect($DAL);
        $query = DatabaseMarketingORM::$dbm->listViewFromSchema($schema);
        try {
            $prepare = DatabaseMarketingORM::$conn->prepare($query);
            $prepare->execute();
            $prepare->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $prepare->fetchAll();
            return $rows;
        } catch (Exception $e) {
            LogErroORM::gerarLogSelect($e->getMessage(), $query);
            return false;
        }
    }

    public static function listColmaps($DAL, $schema, $table, $NOT_IN = null) {
        /* Faz conexão do o banco */
        DatabaseMarketingORM::connect($DAL);
        $query = DatabaseMarketingORM::$dbm->listColmaps($schema,$table,$NOT_IN);
        try {
            $prepare = DatabaseMarketingORM::$conn->prepare($query);
            $prepare->execute();
            $prepare->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $prepare->fetchAll();
            return $rows;
        } catch (Exception $e) {
            LogErroORM::gerarLogSelect($e->getMessage(), $query);
            return false;
        }
    }

}
