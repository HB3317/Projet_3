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
    
    else {
        echo "Commande inconnue" . PHP_EOL;
    }
}
