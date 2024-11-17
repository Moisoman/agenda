<?php
session_start(); // Start the session

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['usuarioLogado']);
$usuarioLogado = $isLoggedIn ? $_SESSION['usuarioLogado'] : null;

$isClinicaLoggedIn = isset($_SESSION['clinicaLogada']);
$clinicaLogada = $isClinicaLoggedIn ? $_SESSION['clinicaLogada'] : null;


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Odontológicos Online</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
}

/* Cabeçalho */
.header {
    background-color: #007bff;
    padding: 10px 20px; /* Adjust padding for better spacing */
    display: flex;
    justify-content: space-between; /* Space out the logo and navigation */
    align-items: center; /* Align items vertically */
    color: white;
}

.header .logo {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between logo and text */
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.header img {
    height: 30px;
    margin-left: 10px;
}

.header nav {
    display: flex;
    gap: 20px;
    align-items: center; /* Align nav links vertically */
}

.header nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    text-align: center;
    padding: 10px; /* Add padding for better clickable area */
}

.header .profile {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding-right: 10px;
}

.header .profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

#user-name {
    font-size: 16px; /* Nome do usuário um pouco menor */
    font-weight: bold;
}

#dropdown-arrow {
    font-size: 14px; /* Tamanho da seta menor */
    color: white;
    transition: transform 0.3s ease; /* Transição suave para a seta */
}

.dropdown-menu {
    display: block;
    position: absolute;
    top: 60px;
    right: 5px;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    transition: max-height 0.5s ease, opacity 0.5s ease; /* Animação suave para altura e opacidade */
}

.dropdown-menu.show {
    max-height: 200px; /* Altura máxima ao expandir o menu */
    opacity: 1;
}

.dropdown-menu a {
    display: block;
    padding: 10px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #ccc;
}

.dropdown-menu a:hover {
    background-color: #f0f0f0;
}

/* Conteúdo principal */
.main-content {
    text-align: center;
    margin-top: 50px;
}

.main-content img {
    max-width: 100%;
    height: auto;
}

.title {
    font-size: 32px;
    margin: 20px 0;
    font-style: inherit;
}

.description {
    font-size: 18px;
    margin: 10px 0 40px 0;
}

/* Rodapé com botões no canto inferior direito */
.footer {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.footer a, .footer button {
    padding: 0;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    cursor: pointer;
    transition: transform 0.3s ease;
    overflow: hidden;
}

.footer a img, .footer button img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background-color: #fff;
    border-radius: 50%;
}

.footer button:hover, .footer a:hover {
    transform: scale(1.1);
}

.toggle-arrow {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    border: none;
    font-size: 18px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.toggle-arrow:hover {
    background-color: #0056b3;
    transform: scale(1.1);
}

.buttons.hidden {
    opacity: 0;
    transform: translateY(20px);
    visibility: hidden;
}

.buttons.visible {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <div class="logo">
            <img src="../img/logo.png" alt="Univel TADS Logo" /> 
            Univel TADS
        </div>
        <nav>
            <a href="#"></a>
            <a href="#"></a>
            <a href="../Telas/telaInfo.php">Quem somos</a>
            <a href="#"></a>

            <!-- If clinic is logged in, show "Clinica" button, otherwise show login link -->
            <?php if ($isClinicaLoggedIn): ?>
                <a href="../Telas/clinicaDashboard.php"> Página da Clinica</a> <!-- Redirect to clinic dashboard -->
            <?php else: ?>
                <a href="../Telas/telaLoginClinicas.php">Login Clinicas</a> <!-- Redirect to clinic login page -->
            <?php endif; ?>

            <!-- Display Login or Meu Perfil based on login status -->
            <?php if (!$isLoggedIn): ?>
                <a href="../Telas/telaLogin.php" id="login-link">Login Paciente</a>
            <?php else: ?>
                
                <div class="profile" id="user-profile" style="display:flex; align-items: center;">
                    <!--<img src="../img/<?= $usuarioLogado['imagem'] ?>" alt="User Profile" id="profile-image" style="width: 40px; height: 40px; border-radius: 50%;">-->
                    <span id="user-name" style="font-weight: bold;"><?= $usuarioLogado['nome'] ?></span>
                </div>
                <a href="../Telas/telaPerfil.php" id="perfil-link">Meu Perfil</a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Menu Dropdown -->
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="#">Dados Pessoais</a>
        <a href="#">Configurações</a>
        <?php if ($isLoggedIn): ?>
            <a href="telaAgendamento.php" id="agendamento-link" style="display: block;">Agendamentos</a>
            <a href="#" id="logout">Sair</a>
        <?php endif; ?>
    </div>

    <!-- Conteúdo principal -->
    <div class="main-content">
        <div class="title">Serviços odontológicos online</div>
        <img src="../img/odontologia.png" alt="Serviços odontológicos online">
        <div class="description">Cuide do seu sorriso com facilidade: agende sua consulta online em nossa clínica odontológica especializada!</div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <div class="buttons visible" id="button-container">
            <a href="#">
                <img src="../img/facebook.png" alt="Facebook">
            </a>
            <a href="#">
                <img src="../img/twitter.png" alt="Twitter">
            </a>
            <a href="#">
                <img src="../img/whatsapp.png" alt="WhatsApp">
            </a>
            <div class="link">
                <button onclick="copyLink()">
                    <img src="../img/link.png" alt="Copiar link">
                </button>
            </div>
        </div>
        <button class="toggle-arrow" id="toggle-button" onclick="toggleButtons()">↓</button>
    </div>

    <script>
        // Function to copy current page link
        function copyLink() {
            const dummy = document.createElement('textarea');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('Link copiado!');
        }

        // Toggle visibility of social buttons in footer
        function toggleButtons() {
            const buttonContainer = document.getElementById('button-container');
            const toggleButton = document.getElementById('toggle-button');
            if (buttonContainer.classList.contains('hidden')) {
                buttonContainer.classList.remove('hidden');
                buttonContainer.classList.add('visible');
                toggleButton.textContent = '↓';
            } else {
                buttonContainer.classList.remove('visible');
                buttonContainer.classList.add('hidden');
                toggleButton.textContent = '↑';
            }
        }

        // Function to handle user login check and profile display
        function checkLogin() {
            const userProfile = document.getElementById('user-profile');
            const userName = document.getElementById('user-name');
            const profileImage = document.getElementById('profile-image');
            
            const usuarioLogado = <?= json_encode($usuarioLogado) ?>;
            if (usuarioLogado) {
                userProfile.style.display = 'flex';
                userName.textContent = usuarioLogado.nome;
                profileImage.src = usuarioLogado.imagem || 'img/profile.jpg';
            }
        }

        

        // Calling checkLogin on page load to ensure login status is checked
        window.onload = checkLogin;
    </script>

</body>
</html>
