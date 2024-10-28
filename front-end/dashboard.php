<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: telaLogin.php'); // Redireciona se não estiver logado
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <h1>Bem-vindo ao sistema, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <a href="logoutUsuario.php">Sair</a>

</body>
</html>
