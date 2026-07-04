<?php

if (!class_exists('Database')) {
class Database 
{
    private static ?PDO $pdo = null;
    
    public static function getConnection(): PDO {
        if(self::$pdo === null) {
            self::$pdo = new \PDO('mysql:host=localhost;dbname=yap;charset=utf8mb4', 'root', '',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
        }
        return self::$pdo;
   }
}
}