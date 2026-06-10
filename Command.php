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

    public function delete(int $id): void 
    {
        $contact = $this->contactManager->findById($id);

        if ($contact) {
            $this->contactManager->delete($id);
            echo "Le contact avec l'ID $id a été supprimé avec succès." . PHP_EOL;
        } else {
            echo "Contact avec l'ID $id non trouvé." . PHP_EOL;
        }
    }

    public function modify(int $id, string $name, string $email, string $phoneNumber): void 
    {
        $contact = $this->contactManager->findById($id);

        if ($contact) {
            $this->contactManager->modify($id, $name, $email, $phoneNumber);
            echo "Le contact avec l'ID $id a été modifié avec succès." . PHP_EOL;
        } else {
            echo "Contact avec l'ID $id non trouvé." . PHP_EOL;
        }
    }
}
