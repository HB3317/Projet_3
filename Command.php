<?php

require_once "ContactManager.php";

class Command 
{
    private ContactManager $contactManager;

    public function __construct(ContactManager $contactManager) 
    {
        $this->contactManager = $contactManager;
    }

    public function list(): void 
    {
        $contacts = $this->contactManager->findAll();

        foreach ($contacts as $contact) {
            echo $contact->toString() . PHP_EOL;
        }
    }

    public function detail(int $id): void 
    {
        $contact = $this->contactManager->findById($id);

        if ($contact) {
            echo $contact->toString() . PHP_EOL;
        } else {
            echo "Contact avec l'ID $id non trouvé." . PHP_EOL;
        }
    }

    public function create(string $name, string $email, string $phoneNumber): void 
    {
        $this->contactManager->create($name, $email, $phoneNumber);
        echo "Le contact " . $name . " a été ajouté avec succès." . PHP_EOL;
    }
}
