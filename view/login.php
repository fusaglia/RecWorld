<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Accesso</h2>

<!--
<?php if ($errore): ?>
    <p style="color: red;"><?php echo htmlspecialchars($errore); ?></p>
<?php endif; ?>
-->

<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>
    
    <label>Telefono:</label><br>
    <input type="text" name="telefono" required><br><br>
    
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    
    <input type="submit" value="Log In">
</form>

</body>
</html>