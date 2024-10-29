<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/trabalhofinal/index.php">Home</a><br><br>

<h2>Editar Dados do Usuário</h2>

<form action="editar.php" method="post">

    <label for="nome">Novo Nome:</label><br>
    <input type="text" id="nome" name="nome"><br><br>
   

    <label for="senha">Nova Senha:</label><br>
    <input type="password" id="senha" name="senha"><br><br>

    <input type="submit" value="Atualizar Usuário">
</form>

<?php
// Verificar se o usuário está logado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: edicao.php");
    exit();
}

// Incluir o arquivo de conexão
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário de edição
    $nome = $_POST['nome'];
    /*$idade = $_POST['idade'];*/
    $senha = $_POST['senha'];
    $usuario_id = $_SESSION['usuario_id'];

    // Preparar a query de atualização
    $sql = "UPDATE usuarios SET nome=?, senha=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    // Se a senha não for alterada, mantenha a antiga
    if (empty($senha)) {
        // Buscar a senha antiga
        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("i", $usuario_id);
        $stmt2->execute();
        $resultado = $stmt2->get_result();
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            $senha = $usuario['senha'];
        }
        $stmt2->close();
    } else {
        // Fazer hash da nova senha
        $senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    // Vincular os parâmetros e executar a query de atualização
    $stmt->bind_param("ssi", $nome, $senha, $usuario_id);
    if ($stmt->execute()) {
        echo "Dados do usuário atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados: " . $conn->error;
    }

    // Fechar statement e conexão
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
