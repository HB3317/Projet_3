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
}