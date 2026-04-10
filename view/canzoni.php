<?php
session_start();
require_once("../controller/connessione.php");

$sql = "SELECT id, titolo, autore, anno, voto, user_id FROM recommendation_canzoni ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canzoni — RecWorld</title>
    <link rel="stylesheet" href="../model/style.css">
</head>
<body>

<header class="site-header">
    <div class="site-header__inner">
        <a href="../index.php" class="site-logo">Rec<span>World</span></a>
        <div>
            <?php if(isset($_SESSION["user_id"])): ?>
                <span class="text-muted" style="margin-right: 12px;">Ciao, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong> 👋</span>
                <a href="logout.php" class="btn btn-ghost">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-ghost">Login / Registrati</a>
            <?php endif; ?>
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

<main>
    <div style="max-width:900px; margin: 40px auto 24px; padding: 0 24px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div class="section-label">Categoria</div>
            <h2 style="margin-bottom:0;">Canzoni</h2>
        </div>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="aggiungiCanzone.php" class="btn">+ Aggiungi consiglio</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline">+ Aggiungi consiglio</a>
        <?php endif; ?>
    </div>

    <div class="card-grid">
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div style="width:100%; height:180px; background:var(--surface-2); border-radius:8px; margin-bottom:16px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--text-faint); gap:8px;">
                        <span style="font-size:2.5rem;">🎵</span>
                        <?php if(!empty($row["autore"])): ?>
                            <span style="font-size:0.8rem; color:var(--text-muted);"><?php echo htmlspecialchars($row["autore"]); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($row["anno"])): ?>
                            <span style="font-size:0.75rem;"><?php echo htmlspecialchars($row["anno"]); ?></span>
                        <?php endif; ?>
                    </div>

                    <span class="badge badge-canzone">Canzone</span>
                    <h3><?php echo htmlspecialchars($row["titolo"]); ?></h3>

                    <?php if(!is_null($row["voto"])): ?>
                        <div class="vote">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php echo $i <= $row["voto"] ? "★" : "☆"; ?>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row["user_id"]): ?>
                        <form method="POST" action="elimina.php" onsubmit="return confirm('Sei sicuro di voler eliminare questo consiglio?');" style="margin-top:12px;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="tabella" value="recommendation_canzoni">
                            <input type="hidden" name="ritorna" value="canzoni.php">
                            <button type="submit" class="btn btn-ghost" style="width:100%; color:#ff6b74; border-color:rgba(255,107,116,0.3);">🗑 Elimina</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted" style="padding: 0 24px;">Nessuna canzone consigliata ancora.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    RecWorld © <?php echo date('Y'); ?> — fatti consigliare
</footer>

</body>
</html>