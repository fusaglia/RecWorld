<?php
session_start();

// Solo utenti loggati
if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once("../controller/connessione.php");

$errore = "";
$successo = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $titolo            = trim($_POST["titolo"]);
    $autore            = trim($_POST["autore"]);
    $foto              = trim($_POST["foto"]);
    $data_pubblicazione = $_POST["data_pubblicazione"];
    $descrizione       = trim($_POST["descrizione"]);
    $commento          = trim($_POST["commento"]);
    $voto              = $_POST["voto"];
    $link_acquisto     = trim($_POST["link_acquisto"]);
    $user_id           = $_SESSION["user_id"];

    if(empty($titolo)) {
        $errore = "Il titolo è obbligatorio.";
    } else {
        $sql = "INSERT INTO recommendation_manga (titolo, autore, foto, data_pubblicazione, descrizione, commento, voto, link_acquisto, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $dp = !empty($data_pubblicazione) ? $data_pubblicazione : null;
        $v  = !empty($voto) ? (int)$voto : null;
        $stmt->bind_param("ssssssssi", $titolo, $autore, $foto, $dp, $descrizione, $commento, $v, $link_acquisto, $user_id);

        if($stmt->execute()) {
            header("Location: manga.php");
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
    <title>Aggiungi Manga — RecWorld</title>
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
    <a href="manga.php" class="active">Manga</a>
    <a href="videogiochi.php">Videogiochi</a>
    <a href="canzoni.php">Canzoni</a>
</nav>

<div class="form-container" style="max-width: 600px;">
    <div class="form-box">
        <div class="form-title">Aggiungi Manga</div>
        <p class="form-subtitle">Consiglia un manga alla community</p>

        <?php if($errore): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errore); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Titolo *</label>
                <input type="text" name="titolo" placeholder="Es. Berserk" required>
            </div>

            <div class="form-group">
                <label>Autore</label>
                <input type="text" name="autore" placeholder="Es. Kentaro Miura">
            </div>

            <div class="form-group">
                <label>URL Copertina</label>
                <input type="url" name="foto" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>Data di pubblicazione</label>
                <input type="date" name="data_pubblicazione">
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

            <div class="form-group">
                <label>Link acquisto</label>
                <input type="url" name="link_acquisto" placeholder="https://...">
            </div>

            <div class="form-actions">
                <a href="manga.php" class="btn btn-ghost">Annulla</a>
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