<?php
require_once "DBConnect.php";
$dbConnect = new DBConnect();
$pdo = $dbConnect->getPDO();
var_dump($pdo);
while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";
    if ($line === "list") {
        echo "affichage de la liste:\n";
    }
}