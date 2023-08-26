<?php

$databaseServerName = "localhost";
$databaseUsername = "root";
$databasePassword = "";

try {
  $databaseConnection = new PDO("mysql:host=$databaseServerName;dbname=invoice", $databaseUsername, $databasePassword);
  $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit;
}

if (isset($_GET['list_of'])) {
    try {
        $tableName = $_GET['list_of'];

        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $prepareStatement = $databaseConnection->prepare("SELECT id, name as text FROM $tableName");
        $prepareStatement->execute();
        $prepareStatement->setFetchMode(PDO::FETCH_ASSOC);

        $dataCollection = $prepareStatement->fetchAll();

        // header('Content-Type: application/json');
        echo json_encode($dataCollection);

        return json_encode($dataCollection);
    } catch (\Throwable $th) {
        //throw $th;
        echo "An error occurred: " . $th->getMessage();
    }
}