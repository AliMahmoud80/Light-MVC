<?php


namespace Light\Database;

use Light\Config\ConfigHandler;
use PDO;
use PDOException;

class DatabaseHandler
{
    /**
     * DatabaseHandler constructor.
     */
    private function __construct(){}

    /**
     * Connect To DB
     */
    public static function connect(): void
    {
        $database_configs = ConfigHandler::get('database');

        extract($database_configs);

        try {
            $pdo = new PDO("mysql:dbname={$db_name};host={$host};charset:{$charset}", $username, $password, $options);
        }catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }
}