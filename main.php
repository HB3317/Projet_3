<?php
require_once "DBConnect.php";
$dbConnect = new DBConnect();
$pdo = $dbConnect->getPDO();

require_once "ContactManager.php";
$contactManager = new ContactManager($pdo);

require_once "Command.php";
$command = new Command($contactManager);

while (true) {
    $line = readline("Entrez votre commande [list|detail|create|delete|modify|help|exit]: ");
    echo "Vous avez saisi : $line\n";

    if ($line === "list") {
        $command->list();
    }

    elseif (preg_match("/^detail\s+(\d+)$/", $line, $matches)) {
        $id = (int) $matches[1];
        $command->detail($id);
    }

    elseif ($line === "create") {
        $name = trim(readline("Entrez le nom : "));
        if ($name === "") {
            echo "Le nom ne peut pas être vide." . PHP_EOL;
            continue;
        }

        $email = trim(readline("Entrez l'email : "));
        if ($email === "") {
            echo "L'email ne peut pas être vide." . PHP_EOL;
            continue;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email n'est pas valide." . PHP_EOL;
            continue;
        }

        $phoneNumber = trim(readline("Entrez le numéro de téléphone : "));
        if ($phoneNumber === "") {
            echo "Le numéro de téléphone ne peut pas être vide." . PHP_EOL;
            continue;
        }

        $command->create($name, $email, $phoneNumber);
    }

    elseif ($line === "delete") {
        echo "Liste des utilisateurs :" . PHP_EOL;
        $command->list();  
        $idToDelete = trim(readline("Entrez l'ID du contact à supprimer : "));

        if (!is_numeric($idToDelete)) {
            echo "L'ID doit être un nombre." . PHP_EOL;
            continue;
        }

        $command->delete((int) $idToDelete);
    }

    elseif ($line === "modify") {
        echo "Liste des utilisateurs :" . PHP_EOL;
        $command->list();
        $idToModify = trim(readline("Entrez l'ID du contact à modifier : "));

        if (!is_numeric($idToModify)) {
            echo "L'ID doit être un nombre." . PHP_EOL;
            continue;
        }
        $name = trim(readline("Entrez le nouveau nom : "));
        if ($name === "") {
            echo "Le nom ne peut pas être vide." . PHP_EOL;
            continue;
        }

        $email = trim(readline("Entrez le nouvel email : "));
        if ($email === "") {
            echo "L'email ne peut pas être vide." . PHP_EOL;
            continue;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email n'est pas valide." . PHP_EOL;
            continue;
        }

        $phoneNumber = trim(readline("Entrez le nouveau numéro de téléphone : "));
        if ($phoneNumber === "") {
            echo "Le numéro de téléphone ne peut pas être vide." . PHP_EOL;
            continue;
        }
        $command->modify((int) $idToModify, $name, $email, $phoneNumber);
    }

    elseif ($line === "help") {
        $command->help();
    }

    elseif ($line === "exit") {
        $command->exit();
    }
    
    else {
        echo "Commande inconnue" . PHP_EOL;
    }
}
