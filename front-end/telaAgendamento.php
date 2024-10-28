<?php
session_start();
$host = 'localhost:3306'; // Your database host
$db = 'trabalhofinal'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['usuario_id'])) {
    $userId = $_SESSION['usuario_id'];
} else {
    // Redirecione para a página de login se o usuário não estiver logado
    header('Location: telaLogin.php');
    exit();
}
// Fetch user name

$stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($nomeUsuario);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
 

 



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Agendamento</title>
    <link rel="stylesheet" href="telaAgendamento.css">
</head>
<body>

<div class="container">
    <div class="opcoes">
        <div class="perfil">
            <span id="usuarioNome">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?></span>
            <img src="[URL da foto do perfil]" alt="Foto de perfil">
        </div>
        <h1>Agendamento</h1>
        <form>
            <label for="procedimento">Selecione o procedimento:</label>
            <select id="procedimento" name="procedimento">
                <option value="aparelho">Aparelho Ortodôntico</option>
                <option value="cirurgia">Cirurgias e extrações</option>
                <option value="clareamento">Clareamento dentário</option>
                <option value="clinico">Clínico geral</option>
                <option value="implante">Implante dentário</option>
                <option value="limpeza">Limpeza dentária</option>
                <option value="canal">Tratamento de canal</option>
            </select>

            <div class="botoes">
                <button type="button" id="btnAgendar">Agendar</button>
                <button type="button">Perfil</button>
            </div>
        </form>
    </div>

    <div class="calendario" id="calendario" style="display: none;"></div>
</div>

<script src="calendario.js"></script>
</body>
</html>
