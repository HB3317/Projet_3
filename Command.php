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

    public function help(): void 
    {
        echo "Commandes disponibles :" . PHP_EOL;
        echo "list - Affiche la liste de tous les contacts." . PHP_EOL;
        echo "detail [id] - Affiche les détails du contact avec l'ID spécifié." . PHP_EOL;
        echo "create - Crée un nouveau contact en demandant les informations à l'utilisateur." . PHP_EOL;
        echo "delete - Supprime le contact avec l'ID spécifié." . PHP_EOL;
        echo "modify - Modifie le contact avec l'ID spécifié en demandant les nouvelles informations à l'utilisateur." . PHP_EOL;
        echo "help - Affiche cette aide." . PHP_EOL;
    }

    public function exit(): void 
    {
        echo "Au revoir!" . PHP_EOL;
        exit(0);
    }
}
