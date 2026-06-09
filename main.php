<?php
require_once "DBConnect.php";
$dbConnect = new DBConnect();
$pdo = $dbConnect->getPDO();

require_once "ContactManager.php";
$contactManager = new ContactManager($pdo);
while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";
    if ($line === "list") {
        echo "affichage de la liste:\n";
        $contacts = $contactManager->findAll();
        foreach ($contacts as $contact) {
        echo $contact->toString() . PHP_EOL;
        }
    }
}