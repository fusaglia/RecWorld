<?php
session_start();

// Solo utenti loggati
if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../controller/connessione.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id      = (int)$_POST["id"];
    $tabella = $_POST["tabella"];
    $ritorna = $_POST["ritorna"];

    // Whitelist delle tabelle permesse (sicurezza)
    $tabelle_permesse = [
        "recommendation_manga",
        "recommendation_anime",
        "recommendation_videogioco",
        "recommendation_canzoni"
    ];

    if(!in_array($tabella, $tabelle_permesse)) {
        header("Location: ../index.php");
        exit;
    }

    // Elimina solo se il consiglio appartiene all'utente loggato
    $sql = "DELETE FROM $tabella WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION["user_id"]);
    $stmt->execute();

    header("Location: " . $ritorna);
    exit;
}

// Se arriva in GET senza POST, rimanda alla home
header("Location: ../index.php");
exit;
?>