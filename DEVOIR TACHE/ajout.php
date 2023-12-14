<?php
require 'vendor/autoload.php';
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $dateEntre = $_POST["dateEntre"];
    $dateFin = $_POST["dateFin"];
    $description = $_POST["description"];
    
    
    $result = $collection->insertOne([
        "name" => $name,
        "dateEntre" => $dateEntre,
        "dateFin" => $dateFin,
        "description" => $description,
        "status" => $date,
    ]);

    if ($result->getInsertedCount() > 0) {
        echo "Tâche insérée avec succès.";
    } else {
        echo "Erreur lors de l'insertion de la tâche.";
    }

    header("Location: index.php");
    exit;
}

?>
