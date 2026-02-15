<?php

/**
 * Database connection class using Singleton pattern
 * Kompatibilné s PHP 7.3+
 */
class Database
{
    private static $instance = null;
    private $connection = null;
    
    private $host = 'localhost';
    private $dbname = 'product-catalog';
    private $username = 'root';
    private $password = 'root';
    private $charset = 'utf8mb4';
    
    private function __construct()
    {
        $this->connect();
    }
    
    private function __clone() {}
    
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            );
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
}
