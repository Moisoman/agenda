<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
    <link rel="stylesheet" href="../Telas/style.css">
</head>
<body>
<a href="index.php">Home</a><br><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'conexao.php';

    // Coletar dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone']; 
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Query para inserir um novo usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$hash')";
        if ($conn->query($sql) === TRUE) {
            // Get the last inserted user ID
            $user_id = $conn->insert_id;

            // Now insert the telefone
            $sql_telefone = "INSERT INTO telefone (user_id, numero) VALUES ('$user_id', '$telefone')";
            if ($conn->query($sql_telefone) === TRUE) {
                // Commit the transaction if both inserts are successful
                $conn->commit();
                echo "Usuário e telefone inseridos com sucesso!";
            } else {
                throw new Exception("Erro ao inserir telefone: " . $conn->error);
            }
        } else {
            throw new Exception("Erro ao inserir usuário: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Erro: " . $e->getMessage();
    }

}
?>
</body>
</html>