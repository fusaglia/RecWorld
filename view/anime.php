<?php
session_start();
require_once("../controller/connessione.php");

$sql = "SELECT id, titolo, foto, voto, user_id FROM recommendation_anime ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime — RecWorld</title>
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
    <a href="anime.php" class="active">Anime</a>
    <a href="manga.php">Manga</a>
    <a href="videogiochi.php">Videogiochi</a>
    <a href="canzoni.php">Canzoni</a>
</nav>

<main>
    <div style="max-width:900px; margin: 40px auto 24px; padding: 0 24px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div class="section-label">Categoria</div>
            <h2 style="margin-bottom:0;">Anime</h2>
        </div>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="aggiungiAnime.php" class="btn">+ Aggiungi consiglio</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline">+ Aggiungi consiglio</a>
        <?php endif; ?>
    </div>

    <div class="card-grid">
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <?php if(!empty($row["foto"])): ?>
                        <img src="<?php echo htmlspecialchars($row["foto"]); ?>" alt="<?php echo htmlspecialchars($row["titolo"]); ?>" style="width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:16px;">
                    <?php else: ?>
                        <div style="width:100%; height:180px; background:var(--surface-2); border-radius:8px; margin-bottom:16px; display:flex; align-items:center; justify-content:center; color:var(--text-faint); font-size:2rem;">🎌</div>
                    <?php endif; ?>

                    <span class="badge" style="color:#a78bfa; border-color:rgba(167,139,250,0.4); background:rgba(167,139,250,0.08);">Anime</span>
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
                            <input type="hidden" name="tabella" value="recommendation_anime">
                            <input type="hidden" name="ritorna" value="anime.php">
                            <button type="submit" class="btn btn-ghost" style="width:100%; color:#ff6b74; border-color:rgba(255,107,116,0.3);">🗑 Elimina</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted" style="padding: 0 24px;">Nessun anime consigliato ancora.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    RecWorld © <?php echo date('Y'); ?> — fatti consigliare
</footer>

</body>
</html>