<?php
session_start();
$host = 'localhost:3306'; // Seu host de banco de dados
$db = 'trabalhofinal'; // Nome do banco de dados
$user = 'root'; // Nome de usuário do banco de dados
$pass = ''; // Senha do banco de dados

$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['usuario_id'])) {
    $userId = $_SESSION['usuario_id'];
} else {
    // Redireciona para a página de login se o usuário não estiver logado
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

// Fetch clinics
$stmt = $conn->prepare("SELECT id, nome FROM clinicas");
$stmt->execute();
$stmt->bind_result($clinicaId, $clinicaNome);
$clinicas = [];

while ($stmt->fetch()) {
    $clinicas[] = ['id' => $clinicaId, 'nome' => $clinicaNome];
}
$stmt->close();
// Processa o agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_agendamento'])) {
    $clinicaId = $_POST['clinica'];
    $procedimento = $_POST['procedimento'];
    $dataHora = date('Y-m-d H:i:s'); 

    // Insere o agendamento
    $stmt = $conn->prepare("INSERT INTO agendamentos (usuario_id, clinica_id, procedimento, data_hora) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userId, $clinicaId, $procedimento, $dataHora);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento realizado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao realizar o agendamento: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
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
        <form method="POST" action="">
            <label for="clinica">Selecione a clínica:</label>
            <select id="clinica" name="clinica" required>
                <option value="">Selecione uma clínica</option>
                <?php foreach ($clinicas as $clinica): ?>
                    <option value="<?php echo $clinica['id']; ?>">
                        <?php echo htmlspecialchars($clinica['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="procedimento">Selecione o procedimento:</label>
            <select id="procedimento" name="procedimento" required>
                <option value="">Selecione um procedimento</option>
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
                <button type="submit" name="confirmar_agendamento">CONFIRMAR</button>
            </div>
        </form>
    </div>

    <div class="calendario" id="calendario" style="display: none;"></div>
</div>

<script src="calendario.js"></script>
</body>
</html>
