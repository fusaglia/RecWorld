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
    $piattaforma = trim($_POST["piattaforma"]);
    $genere      = trim($_POST["genere"]);
    $voto        = $_POST["voto"];
    $user_id     = $_SESSION["user_id"];

    if(empty($titolo)) {
        $errore = "Il titolo è obbligatorio.";
    } else {
        $sql = "INSERT INTO recommendation_videogioco (titolo, foto, descrizione, commento, piattaforma, genere, voto, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $v = !empty($voto) ? (int)$voto : null;
        $stmt->bind_param("ssssssis", $titolo, $foto, $descrizione, $commento, $piattaforma, $genere, $v, $user_id);

        if($stmt->execute()) {
            header("Location: videogiochi.php");
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
    <title>Aggiungi Videogioco — RecWorld</title>
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
    <a href="anime.php">Anime</a>
    <a href="manga.php">Manga</a>
    <a href="videogiochi.php" class="active">Videogiochi</a>
    <a href="canzoni.php">Canzoni</a>
</nav>

<div class="form-container" style="max-width: 600px;">
    <div class="form-box">
        <div class="form-title">Aggiungi Videogioco</div>
        <p class="form-subtitle">Consiglia un videogioco alla community</p>

        <?php if($errore): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errore); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Titolo *</label>
                <input type="text" name="titolo" placeholder="Es. The Witcher 3" required>
            </div>

            <div class="form-group">
                <label>URL Copertina</label>
                <input type="url" name="foto" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Piattaforma</label>
                <select name="piattaforma">
                    <option value="">— seleziona —</option>
                    <option value="PC">PC</option>
                    <option value="PlayStation">PlayStation</option>
                    <option value="Xbox">Xbox</option>
                    <option value="Nintendo Switch">Nintendo Switch</option>
                    <option value="Mobile">Mobile</option>
                    <option value="Multipiattaforma">Multipiattaforma</option>
                </select>
            </div>

            <div class="form-group">
                <label>Genere</label>
                <input type="text" name="genere" placeholder="Es. RPG, FPS, Avventura...">
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
                <a href="videogiochi.php" class="btn btn-ghost">Annulla</a>
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