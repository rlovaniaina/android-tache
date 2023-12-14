<?php
require 'vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$todolistDB = $mongoClient->todolist;
$tasksCollection = $todolistDB->tasks;
?>