<?php

require_once 'config.php';

class DBConnect
{
    public function getPDO(): PDO
    {
        return new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASSWORD
        );
    }
}