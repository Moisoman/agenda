<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exclusão de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/trabalhofinal/index.php">Home</a><br><br>

<h2>Exclusão de Usuário</h2>

<form action="exclusao.php" method="post">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
   
    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <input type="submit" value="Excluir Usuário">
</form><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir o arquivo de conexão
    require_once 'conexao.php';

    // Coletar dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Query para buscar o usuário pelo e-mail
$sql = "SELECT senha FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    // Verificar se a senha está correta
    if (password_verify($senha, $usuario['senha'])) {
        // Senha correta, executar a exclusão
        $sql = "DELETE FROM usuarios WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            echo "Usuário excluído com sucesso!";
        } else {
            echo "Erro ao excluir usuário: " . $conn->error;
        }
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "E-mail não encontrado!";
}

// Fechando conexão com o banco de dados
$conn->close();
}
?>

</body>
</html>
