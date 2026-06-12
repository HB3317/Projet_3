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

    public function init() : void
    {
        $dbConnect = new DBConnect();
        $pdo = $dbConnect->getPDO();
        $contactManager = new ContactManager($pdo);
        $this->command = new Command($contactManager);
    }
    
    public function run() : void 
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

    public function create() : void
    {
        $name = trim(readline("Entrez le nom : "));
        if ($name === "") {
            echo "Le nom ne peut pas être vide." . PHP_EOL;
            return;
        }

        $email = trim(readline("Entrez l'email : "));
        if ($email === "") {
            echo "L'email ne peut pas être vide." . PHP_EOL;
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email n'est pas valide." . PHP_EOL;
            return;
        }

        $phoneNumber = trim(readline("Entrez le numéro de téléphone : "));
        if ($phoneNumber === "") {
            echo "Le numéro de téléphone ne peut pas être vide." . PHP_EOL;
            return;
        }

        $this->command->create($name, $email, $phoneNumber);
    }
    public function delete() : void
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
    public function modify() : void
    {
        echo "Liste des utilisateurs :" . PHP_EOL;
        $this->command->list();
        $idToModify = trim(readline("Entrez l'ID du contact à modifier : "));

        if (!is_numeric($idToModify)) {
            echo "L'ID doit être un nombre." . PHP_EOL;
            return;
        }
        $name = trim(readline("Entrez le nouveau nom : "));
        if ($name === "") {
            echo "Le nom ne peut pas être vide." . PHP_EOL;
            return;
        }

        $email = trim(readline("Entrez le nouvel email : "));
        if ($email === "") {
            echo "L'email ne peut pas être vide." . PHP_EOL;
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email n'est pas valide." . PHP_EOL;
            return;
        }

        $phoneNumber = trim(readline("Entrez le nouveau numéro de téléphone : "));
        if ($phoneNumber === "") {
            echo "Le numéro de téléphone ne peut pas être vide." . PHP_EOL;
            return;
        }
        $this->command->modify((int) $idToModify, $name, $email, $phoneNumber);
    }

}

new Main();