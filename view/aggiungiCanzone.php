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
    $autore      = trim($_POST["autore"]);
    $genere      = trim($_POST["genere"]);
    $anno        = $_POST["anno"];
    $album       = trim($_POST["album"]);
    $commento    = trim($_POST["commento"]);
    $link_video  = trim($_POST["link_video"]);
    $voto        = $_POST["voto"];
    $user_id     = $_SESSION["user_id"];

    if(empty($titolo)) {
        $errore = "Il titolo è obbligatorio.";
    } else {
        $sql = "INSERT INTO recommendation_canzoni (titolo, autore, genere, anno, album, commento, link_video, voto, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $a = !empty($anno) ? (int)$anno : null;
        $v = !empty($voto) ? (int)$voto : null;
        $stmt->bind_param("sssississi", $titolo, $autore, $genere, $a, $album, $commento, $link_video, $v, $user_id);

        if($stmt->execute()) {
            header("Location: canzoni.php");
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
    <title>Aggiungi Canzone — RecWorld</title>
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
    <a href="videogiochi.php">Videogiochi</a>
    <a href="canzoni.php" class="active">Canzoni</a>
</nav>

<div class="form-container" style="max-width: 600px;">
    <div class="form-box">
        <div class="form-title">Aggiungi Canzone</div>
        <p class="form-subtitle">Consiglia una canzone alla community</p>

        <?php if($errore): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errore); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Titolo *</label>
                <input type="text" name="titolo" placeholder="Es. Bohemian Rhapsody" required>
            </div>

            <div class="form-group">
                <label>Artista / Autore</label>
                <input type="text" name="autore" placeholder="Es. Queen">
            </div>

            <div class="form-group">
                <label>Genere</label>
                <input type="text" name="genere" placeholder="Es. Rock, Pop, Jazz...">
            </div>

            <div class="form-group">
                <label>Anno</label>
                <input type="number" name="anno" placeholder="Es. 1975" min="1900" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label>Album</label>
                <input type="text" name="album" placeholder="Es. A Night at the Opera">
            </div>

            <div class="form-group">
                <label>Il tuo commento</label>
                <textarea name="commento" placeholder="Perché la consigli?"></textarea>
            </div>

            <div class="form-group">
                <label>Link video (YouTube ecc.)</label>
                <input type="url" name="link_video" placeholder="https://youtube.com/...">
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
                <a href="canzoni.php" class="btn btn-ghost">Annulla</a>
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