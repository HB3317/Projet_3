<?php
require_once "DBConnect.php";
require_once "ContactManager.php";
require_once "Command.php";

class Main 
{
    private Command $command;

    public function __construct ()
    {
        $this->init();
        $this->run();
    }

    private function init() : void
    {
        $dbConnect = new DBConnect();
        $pdo = $dbConnect->getPDO();
        $contactManager = new ContactManager($pdo);
        $this->command = new Command($contactManager);
    }
    
    private function run() : void 
    {
        while (true) {
            $line = readline("Entrez votre commande [list|detail|create|delete|modify|help|exit]: ");
            echo "Vous avez saisi : $line\n";

            if ($line === "list") {
                $this->command->list();
            }

            elseif (preg_match("/^detail\s+(\d+)$/", $line, $matches)) {
                $id = (int) $matches[1];
                $this->command->detail($id);
            }

            elseif ($line === "create") {
                $this->create();
            }

            elseif ($line === "delete") {
                $this->delete();
            }

            elseif ($line === "modify") {
                $this->modify();
            }

            elseif ($line === "help") {
                $this->command->help();
            }

            elseif ($line === "exit") {
                $this->command->exit();
            }
            
            else {
                echo "Commande inconnue" . PHP_EOL;
            }
        }
    }

    private function getNewUserInput() : ?array
    {
        $name = trim(readline("Entrez le nom : "));
        if ($name === "") {
            echo "Le nom ne peut pas être vide." . PHP_EOL;
            return null;
        }

        $email = trim(readline("Entrez l'email : "));
        if ($email === "") {
            echo "L'email ne peut pas être vide." . PHP_EOL;
            return null;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email n'est pas valide." . PHP_EOL;
            return null;
        }

        $phoneNumber = trim(readline("Entrez le numéro de téléphone : "));
        if ($phoneNumber === "") {
            echo "Le numéro de téléphone ne peut pas être vide." . PHP_EOL;
            return null;
        }
        $newUserInput = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phoneNumber
        ];
        return $newUserInput;
    }
    private function create() : void
    {
        $newUserInput = $this->getNewUserInput();
        if (!empty($newUserInput)) {
            $this->command->create($newUserInput['name'], $newUserInput['email'], $newUserInput['phone_number']);
        }
    }

    private function delete() : void
    {
        echo "Liste des utilisateurs :" . PHP_EOL;
        $this->command->list();  
        $idToDelete = trim(readline("Entrez l'ID du contact à supprimer : "));

        if (!is_numeric($idToDelete)) {
            echo "L'ID doit être un nombre." . PHP_EOL;
            return;
        }

        $this->command->delete((int) $idToDelete);
    }
    private function modify() : void
    {
        echo "Liste des utilisateurs :" . PHP_EOL;
        $this->command->list();
        $idToModify = trim(readline("Entrez l'ID du contact à modifier : "));

        if (!is_numeric($idToModify)) {
            echo "L'ID doit être un nombre." . PHP_EOL;
            return;
        }
        $newUserInput = $this->getNewUserInput();
        if (!empty($newUserInput)) {
            $this->command->modify((int) $idToModify, $newUserInput['name'], $newUserInput['email'], $newUserInput['phone_number']);
        }
    }

}

new Main();