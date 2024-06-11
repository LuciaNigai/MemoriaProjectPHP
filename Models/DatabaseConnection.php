<?php

class DatabaseConnection {
    private static $instance = null;
    private $connection; 
    
    private function __construct() {
        // Use a relative path to include the config file
        $config = include('../config/config.php');
        $database_host = $config['db_host'];
        $database_name = $config['db_name'];
        $database_charset = $config['db_charset'];
        $database_port = $config['db_port'];
        $user_name = $config['db_user'];
        $password = $config['db_password']; // Correct variable name

        try {
            $dsn = "mysql:host={$database_host};dbname={$database_name};charset={$database_charset};port={$database_port}";
            $this->connection = new PDO($dsn, $user_name, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            die('Database connection failed. Please try again later.');
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->connection;
    }
}
