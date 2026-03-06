<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "recworld";   // nome del tuo database

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

?>