<?php
require_once 'Contact.php';

class ContactManager {
    private PDO $pdo;

    public function __construct(PDO $pdo){  
    $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM contact');

        $contacts = [];
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $contact = new Contact();

            $contact->setId((int) $row['id']);
            $contact->setName($row['name']);
            $contact->setEmail($row['email']);
            $contact->setPhoneNumber($row['phone_number']);

            $contacts[] = $contact;
        }

        return $contacts;
    }
}