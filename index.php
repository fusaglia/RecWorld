<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecWorld</title>
    <link rel="stylesheet" href="model/style.css">
</head>
<body>

<!-- HEADER: titolo a sinistra, login a destra -->
<header class="site-header">
    <div class="site-header__inner">
        <a href="index.php" class="site-logo">Rec<span>World</span></a>

        <div>
            <?php if(isset($_SESSION["user_id"])): ?>
                <span class="text-muted" style="margin-right: 12px;">Ciao, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong> 👋</span>
                <a href="view/logout.php" class="btn btn-ghost">Logout</a>
            <?php else: ?>
                <a href="view/login.php" class="btn btn-ghost">Login / Registrati</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- NAVBAR CATEGORIE -->
<nav class="category-nav">
    <a href="index.php">Home</a>
    <a href="view/anime.php">Anime</a>
    <a href="view/manga.php">Manga</a>
    <a href="view/videogiochi.php">Videogiochi</a>
    <a href="view/canzoni.php">Canzoni</a>


</nav>

<!-- CONTENUTO PRINCIPALE -->
<main>
    <div class="card-grid">
        <!-- I consigli verranno mostrati qui -->
    </div>
</main>

<footer>
    RecWorld © <?php echo date('Y'); ?> — fatti consigliare
</footer>

</body>
</html>