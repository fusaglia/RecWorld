<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>RecWorld</title>
</head>
<body>

<h1>Benvenuto su RecWorld</h1>

<?php if(isset($_SESSION["user_id"])): ?>       <!-- se trova l'utente loggato, mostra il suo nome e i pulsanti di logout e aggiunta consiglio -->
    
    <p>Ciao <?php echo $_SESSION["username"]; ?> 👋</p>
    <a href="view/logout.php"><button>Logout</button></a>
    <a href="view/add_recommendation.php"><button>Aggiungi consiglio</button></a>

<?php else: ?>      <!-- altrimenti mostra il pulsante di login/registrazione -->

    <a href="view/login.php"><button>Login / Registrati</button></a>
    
<?php endif; ?>

<!-- Qui puoi mostrare i consigli pubblici a tutti -->
</body>
</html>