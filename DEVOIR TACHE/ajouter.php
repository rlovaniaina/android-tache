<?php
require 'vendor/autoload.php';
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une tâche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="row">
        <h2>Ajouter une tâche</h2>
        
        <form action="ajouter.php" method="post">
            <div ><div>
                <label for="name">Nom:</label>
                <input  type="text" name="name" required>
            </div>
            <div>
                <label for="dateEntre">Date d'entrée:</label>
                <input type="date" name="dateEntre" required>
            </div>
     
            <div>
                <label for="dateFin">Date de fin:</label>
                <input type="date" name="dateFin" required>
            </div>
 
            <div>
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
            </div>
     
            <div>
                <button class="vu" type="submit">Ajouter la tâche</button>
            </div>
            
        </form>
    </div>
    
</body>
</html>