<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/trabalhofinal/index.php">Home</a><br><br>

<h2>Login para Edição</h2>

<form action="login_edicao.php" method="post">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
   
    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <input type="submit" value="Entrar">
</form>

<?php
// Incluir o arquivo de conexão
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o e-mail e senha estão corretos
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            // Iniciar sessão e armazenar dados do usuário
            session_start();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];

            // Redirecionar para a página de edição
            header("Location: editar.php");
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "E-mail não encontrado!";
    }

    // Fechar statement e conexão
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
