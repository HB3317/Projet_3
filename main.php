<?php
require_once "DBConnect.php";
$dbConnect = new DBConnect();
$pdo = $dbConnect->getPDO();

require_once "ContactManager.php";
$contactManager = new ContactManager($pdo);

require_once "Command.php";
$command = new Command($contactManager);

while (true) {
    $line = readline("Entrez votre commande : ");
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
    
    else {
        echo "Commande inconnue" . PHP_EOL;
    }
}
