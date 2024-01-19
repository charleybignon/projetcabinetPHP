<?php
namespace Config;
class Database {
    const SERVER = "localhost";
    const DB = "cabinet";
    const LOGIN = "root";
    const PWD = "";
    private static $linkpdo = null;

    private function __contruct() {}

    public static function getInstance() : \PDO {
        if(self::$linkpdo === null) {
            self::$linkpdo = new \PDO("mysql:host=" . self::SERVER . ";dbname=" . self::DB, self::LOGIN, self::PWD);
            self::$linkpdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$linkpdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        }
        return self::$linkpdo;
    }

// tets git
}