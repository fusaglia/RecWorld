<?php
session_start();
require_once("../config/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"];
    $mail = $_POST["mail"];
    $password = $_POST["password"];

    // Cerco utente tramite mail
    $sql = "SELECT * FROM users WHERE mail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        // Utente trovato → login
        $user = $result->fetch_assoc();

        if(password_verify($password, $user["password"])){

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: ../index.php");
            exit;

        } else {
            echo "Password sbagliata";
        }

    } else {

        // Utente non trovato → registrazione
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, mail, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $mail, $hashedPassword);
        $stmt->execute();

        $_SESSION["user_id"] = $stmt->insert_id;
        $_SESSION["username"] = $username;

        header("Location: ../index.php");
        exit;
    }
}
?>