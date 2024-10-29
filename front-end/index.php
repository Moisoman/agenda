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
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }

        .header .logo {
            display: flex;
            align-items: center;
            padding: 10px;
            gap: 20px;
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
        }

        .header nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }

        .header .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding-right: 10px;
        }

        .header .profile img {
            width: 50px;
            height: 50px;
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
            <img src="img/logo.png" alt="Univel TADS Logo" /> 
             Univel TADS
        </div>
        <nav>
            <a href="#">Contato</a>
            <a href="#">Sobre nós</a>
            <a href="#">Cliente</a>
            <a href="#">Serviços</a>
            <a href="telaLogin.php" id="login-link">Login</a>
            <!-- Elemento de perfil de usuário que será exibido após o login -->
            <div class="profile" id="user-profile" style="display:none;">
                <img src="img/profile.jpg" alt="User Profile" id="profile-image">
                <span id="user-name"></span>
                <span id="dropdown-arrow">↓</span> <!-- Seta ao lado do nome -->
            </div>
        </nav>
    </div>

    <!-- Menu Dropdown -->
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="#">Dados Pessoais</a>
        <a href="#">Configurações</a>
        <a href="telaAgendamento.php" id="agendamento-link" style="display: none;">Agendamento</a>
        <a href="#" id="logout">Sair</a>
    </div>

    <!-- Conteúdo principal -->
    <div class="main-content">
        <div class="title">Serviços odontológicos online</div>
        <img src="img/odontologia.png" alt="Serviços odontológicos online">
        <div class="description">Cuide do seu sorriso com facilidade: agende sua consulta online em nossa clínica odontológica especializada!</div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <div class="buttons visible" id="button-container">
            <a href="#">
                <img src="img/facebook.png" alt="Facebook">
            </a>
            <a href="#">
                <img src="img/twitter.png" alt="Twitter">
            </a>
            <a href="#">
                <img src="img/whatsapp.png" alt="WhatsApp">
            </a>
            <div class="link">
                <button onclick="copyLink()">
                    <img src="img/link.png" alt="Copiar link">
                </button>
            </div>
        </div>
        <button class="toggle-arrow" id="toggle-button" onclick="toggleButtons()">↓</button>
    </div>

    <script>
        function copyLink() {
            const dummy = document.createElement('textarea');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('Link copiado!');
        }

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

        // Função para verificar se o usuário está logado
        function checkLogin() {
            const userProfile = document.getElementById('user-profile');
            const userName = document.getElementById('user-name');
            const profileImage = document.getElementById('profile-image');

            const usuarioLogado = JSON.parse(sessionStorage.getItem('usuarioLogado'));
            if (usuarioLogado) {
                // Esconde o link de login
                document.getElementById('login-link').style.display = 'none';
                // Exibe o perfil do usuário
                userProfile.style.display = 'flex';
                document.getElementById('agendamento-link').style.display = 'block';
                userName.textContent = usuarioLogado.nome; // Exibe o nome do usuário
                profileImage.src = usuarioLogado.imagem || 'img/profile.jpg'; // Define imagem padrão caso não exista
            }
        }

        // Função para logout
        function logout() {
            sessionStorage.removeItem('usuarioLogado'); // Remove usuário logado
            window.location.href = "login.html"; // Redireciona para a página de login
        }

        // Dropdown Menu para o perfil do usuário
        const profile = document.getElementById('user-profile');
        const dropdownMenu = document.getElementById('dropdown-menu');

        profile.addEventListener('click', function () {
            dropdownMenu.classList.toggle('show');

            const dropdownArrow = document.getElementById('dropdown-arrow');
            if (dropdownMenu.classList.contains('show')) {
                dropdownArrow.style.transform = 'rotate(180deg)'; // Seta para cima
            } else {
                dropdownArrow.style.transform = 'rotate(0deg)'; // Seta para baixo
            }
        });

        document.getElementById('logout').addEventListener('click', logout);

        // Chama a função para verificar o login ao carregar a página
        window.onload = checkLogin;

        // Função para obter o usuário logado
        function getUsuarioLogado() {
        return JSON.parse(sessionStorage.getItem('usuarioLogado')) || null;
}
    </script>
</body>
</html>
