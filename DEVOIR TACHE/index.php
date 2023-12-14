<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>  Application de liste de tâches</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    padding: 0;
    background-color: #f4f4f4;
}

h1 {
    text-align: center;
    color: #333;
}

form {
    margin-bottom: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input[type="text"],
input[type="number"],
input[type="date"],
input[type="submit"],
input[type="checkbox"] {
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
}

input[type="submit"] {
    cursor: pointer;
    background-color: #4CAF50;
    color: white;
    border: none;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

hr {
    margin-top: 20px;
    border: 0;
    height: 1px;
    background-color: #ddd;
}

.task {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
}

.task p {
    margin: 5px 0;
}

.task input[type="checkbox"] {
    margin-right: 5px;
}

.delete-btn,
.edit-btn {
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    width: auto;
}

.delete-btn {
    background-color: #ff4d4d; /* Red color for Supprimer button */
}

.delete-btn:hover {
    background-color: #cc0000;
}

.edit-btn {
    background-color: #337ab7; /* Blue color for Modifier button */
}

.edit-btn:hover {
    background-color: #23527c;
}
    </style>
</head>
<body>

<h1>Ajouter une tâche</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="add">
    Nom de la tâche : <input type="text" name="name" required><br>
    Description : <input type="text" name="description" required><br>
    Statut : <input type="number" name="statut" required><br>
    Date de début : <input type="date" name="date_debut" required><br>
    Date de fin : <input type="date" name="date_fin" required><br>
    <input type="checkbox" name="terminee" . $document->terminee ? :
    <input type="submit" value="Ajouter">
</form>

<hr>

<h1>Liste des tâches</h1>

<?php
$client = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$dbName = "todolist";
$collectionName = "tasks";

function getTasks($client, $dbName, $collectionName)
{
    $query = new MongoDB\Driver\Query([]);
    return $client->executeQuery("$dbName.$collectionName", $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'add':
            case 'edit':
                if (
                    isset($_POST["name"]) &&
                    isset($_POST["description"]) &&
                    isset($_POST["statut"]) &&
                    isset($_POST["date_debut"]) &&
                    isset($_POST["date_fin"])
                ) {
                    $task_name = $_POST["name"];
                    $description = $_POST["description"];
                    $status = (int)$_POST["statut"];
                    $date_debut = new MongoDB\BSON\UTCDateTime(strtotime($_POST['date_debut']) / 1000);
                    $date_fin = new MongoDB\BSON\UTCDateTime(strtotime($_POST['date_fin']) / 1000);
                    

                    $bulk = new MongoDB\Driver\BulkWrite;
                    // ...
$terminee = isset($_POST['terminee']) ? true : false; 

$document = [
    'nom_tache' => $task_name,
    'description' => $description,
    'statut' => $status,
    'date_debut' => $date_debut,
    'date_fin' => $date_fin,
    'terminee' => $terminee 
];

                   if ($action === 'add') {
                        $bulk->insert($document);
                    } elseif ($action === 'edit' && isset($_POST['id'])) {
                        $id = new MongoDB\BSON\ObjectId($_POST['id']);
                        $bulk->update(['_id' => $id], ['$set' => $document]);
                    }

                    try {
                        $result = $client->executeBulkWrite("$dbName.$collectionName", $bulk);
                    } catch (Exception $e) {
                        echo "Erreur lors de " . ($action === 'add' ? "l'ajout" : "la modification") . " de la tâche : " . $e->getMessage();
                    }
                }
                break;

            case 'delete':
                if (isset($_POST['id'])) {
                    $id = new MongoDB\BSON\ObjectId($_POST['id']);
                    $bulk = new MongoDB\Driver\BulkWrite;
                    $bulk->delete(['_id' => $id]);

                    try {
                        $result = $client->executeBulkWrite("$dbName.$collectionName", $bulk);
                    } catch (Exception $e) {
                        echo "Erreur lors de la suppression de la tâche : " . $e->getMessage();
                    }
                }
                break;

            default:
                break;
        }
    }
}
// Affichage des tâches
try {
    $tasks = getTasks($client, $dbName, $collectionName);
    foreach ($tasks as $document) {
        // Affichage des détails de la tâche
        // Formulaire de modification de la tâche

        echo "<p>Nom de la tâche : " . $document->nom_tache . "</p>";
        echo "<p>Description : " . $document->description . "</p>";
        echo "<p>Statut : " . $document->statut . "</p>";
        echo "<p>date_debut : " . $document->date_debut . "</p>";
        echo "<p>date_fin : " . $document->date_fin . "</p>";
        echo '<input type="checkbox" name="terminee" ' . ($document->terminee ? 'checked' : '') . '><br>'; 
    

        echo '<form action="" method="post">';
        echo '<input type="hidden" name="action" value="delete">';
        echo '<input type="hidden" name="id" value="' . $document->_id . '">';
        echo '<input type="submit" value="Supprimer">';
        echo '</form>';
        

        echo '<form action="" method="post">';
        echo '<input type="hidden" name="action" value="edit">';
        echo '<input type="hidden" name="id" value="' . $document->_id . '">';
        echo 'Nom de la tâche : <input type="text" name="name" value="' . $document->nom_tache . '" required><br>';
        echo 'Description : <input type="text" name="description" value="' . $document->description . '" required><br>';
        echo 'Statut : <input type="number" name="statut" value="' . $document->statut . '" required><br>';
        echo 'Date de début : <input type="date" name="date_debut" value="' . date("", $document->date_debut->toDateTime()->getTimestamp()) . '" required><br>';
        echo 'Date de fin : <input type="date" name="date_fin" value="' . date("", $document->date_fin->toDateTime()->getTimestamp()) . '" required><br>';
        echo '<label for="terminee">Terminée : </label>';
        echo '<input type="checkbox" name="terminee" ' . ($document->terminee ? 'checked' : '') . '><br>'; 
        echo '<input type="submit" value="Modifier">';
        echo '</form>';

        echo "<hr>";
    }
} catch (Exception $e) {
    echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
}
?>

</body>
</html>

