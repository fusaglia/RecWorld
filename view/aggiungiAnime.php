<?php
session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../controller/connessione.php");

$errore = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $titolo      = trim($_POST["titolo"]);
    $foto        = trim($_POST["foto"]);
    $descrizione = trim($_POST["descrizione"]);
    $commento    = trim($_POST["commento"]);
    $voto        = $_POST["voto"];
    $user_id     = $_SESSION["user_id"];

    if(empty($titolo)) {
        $errore = "Il titolo è obbligatorio.";
    } else {
        $sql = "INSERT INTO recommendation_anime (titolo, foto, descrizione, commento, voto, user_id)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $v = !empty($voto) ? (int)$voto : null;
        $stmt->bind_param("ssssii", $titolo, $foto, $descrizione, $commento, $v, $user_id);

        if($stmt->execute()) {
            header("Location: anime.php");
            exit;
        } else {
            $errore = "Errore durante il salvataggio. Riprova.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Anime — RecWorld</title>
    <link rel="stylesheet" href="../model/style.css">
</head>
<body>

<header class="site-header">
    <div class="site-header__inner">
        <a href="../index.php" class="site-logo">Rec<span>World</span></a>
        <div>
            <span class="text-muted" style="margin-right: 12px;">Ciao, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong> 👋</span>
            <a href="logout.php" class="btn btn-ghost">Logout</a>
        </div>
    </div>
</header>

<nav class="category-nav">
    <a href="../index.php">Home</a>
    <a href="anime.php" class="active">Anime</a>
    <a href="manga.php">Manga</a>
    <a href="videogiochi.php">Videogiochi</a>
    <a href="canzoni.php">Canzoni</a>
</nav>

<div class="form-container" style="max-width: 600px;">
    <div class="form-box">
        <div class="form-title">Aggiungi Anime</div>
        <p class="form-subtitle">Consiglia un anime alla community</p>

        <?php if($errore): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errore); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Titolo *</label>
                <input type="text" name="titolo" placeholder="Es. Fullmetal Alchemist" required>
            </div>

            <div class="form-group">
                <label>URL Copertina</label>
                <input type="url" name="foto" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Descrizione</label>
                <textarea name="descrizione" placeholder="Di cosa parla?"></textarea>
            </div>

            <div class="form-group">
                <label>Il tuo commento</label>
                <textarea name="commento" placeholder="Perché lo consigli?"></textarea>
            </div>

            <div class="form-group">
                <label>Voto (1-5)</label>
                <select name="voto">
                    <option value="">— nessun voto —</option>
                    <option value="1">★☆☆☆☆ — 1</option>
                    <option value="2">★★☆☆☆ — 2</option>
                    <option value="3">★★★☆☆ — 3</option>
                    <option value="4">★★★★☆ — 4</option>
                    <option value="5">★★★★★ — 5</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="anime.php" class="btn btn-ghost">Annulla</a>
                <button type="submit" class="btn">Salva consiglio</button>
            </div>
        </form>
    </div>
</div>

<footer>
    RecWorld © <?php echo date('Y'); ?> — fatti consigliare
</footer>

</body>
</html>