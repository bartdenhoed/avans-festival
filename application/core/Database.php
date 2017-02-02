<?php

/**
 * Database class load database and set connection
 */
class Database
{
    private static $database;
    private $connection;

    /**
     * Return database so it is available
     */
    public static function getDatabase()
    {
        // Check connection already exists
        if (!self::$database) {
            // New connection
            self::$database = new Database();
        }

        return self::$database;
    }

    /**
     * Make new database connection using PDO
     */
    public function getConnection() {
        if (!$this->connection) {
            try {
                $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
                $this->connection = new PDO(
                       'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
                       DB_USER,
                       DB_PASS,
                       array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ)
                   );
            } catch (PDOException $error) {
                echo 'Database error: ' . $error->getCode();
                exit;
            }
        }

        return $this->connection;
    }
}
