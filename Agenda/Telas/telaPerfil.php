<?php
session_start(); // Ensure the session is started

// Check if the user is logged in (session data exists)
if (!isset($_SESSION['usuarioLogado'])) {
    // If not logged in, redirect to the login page
    header('Location: telaLogin.php');
    exit;
}

// Get the logged-in user's data from the session
$usuarioLogado = $_SESSION['usuarioLogado'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #007bff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header img {
            height: 30px;
            margin-right: 10px;
        }

        .header nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-weight: bold;
        }

        .main-content {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .main-content h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .user-details div {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
            <span>Univel TADS</span>
        </div>
        <nav>
            <a href="../Auth/index.php">Início</a>
            <a href="telaPerfil.php">Meu Perfil</a>
            <a href="telaAgendamento.php">Agendamentos</a>
            <a href="../Auth/logoutUsuario.php">Sair</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Meu Perfil</h1>

        <!-- User details section -->
        <div class="user-details">
            <div>
                <strong>Nome:</strong>
                <span><?= htmlspecialchars($usuarioLogado['nome']) ?></span>
            </div>
            <div>
                <strong>Email:</strong>
                <span><?= htmlspecialchars($usuarioLogado['email']) ?></span>
            </div>
            <div>
                <strong>Imagem de Perfil:</strong>
                <img src="../img/<?= htmlspecialchars($usuarioLogado['imagem']) ?>" alt="Imagem de Perfil" width="100">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Univel TADS - Todos os direitos reservados</p>
    </div>

</body>
</html>
