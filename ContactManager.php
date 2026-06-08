<?php

class ContactManager {
    private PDO $pdo;

    public function __construct(PDO $pdo){  
    $this->pdo = $pdo;
    }

    public function findAll(): array{
        $statement = $this->pdo->query('SELECT * FROM contact');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}