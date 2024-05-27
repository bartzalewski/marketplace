<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct($config) {
        $this->pdo = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    public static function getInstance($config) {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance->pdo;
    }
}