<?php

namespace GabrielBinottiActiveRecord;
require 'config/config.php';
use Exception;

final class Connection
{
    protected static $pdo;

    private function __construct()
    {

        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;

        try {
            self::$pdo = new \PDO($dsn, DB_USER, DB_PASS);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            self::$pdo->exec('SET NAMES utf8');
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getConnection()
    {

        if (!self::$pdo) {
            new Connection();
        }
        return self::$pdo;
    }


    public static function close()
    {
        self::$pdo->commit();
        self::$pdo = null;
    }

    public static function beginTransaction()
    {
        if (!self::$pdo) {
            throw new Exception("You not have connection with database.");
        }

        self::$pdo->beginTransaction();
    }


    public static function rollback()
    {
        if (!self::$pdo) {
            throw new Exception('You not have connection with database.');
        }
        self::$pdo->rollback();
    }
}
