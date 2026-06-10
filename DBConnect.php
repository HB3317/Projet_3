<?php
class DBConnect {
    public function getPDO() : PDO{
    return new PDO(
        'mysql:host=localhost;dbname=contact_manager;charset=utf8mb4', 
        'root',
        '');
    }
}