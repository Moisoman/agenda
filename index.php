<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="cabecalho">
        <div class="elemento1"></div>
        <div class="elemento2">CADASTRO DE USUÁRIOS</div>
        <div class="elemento3"></div>
    </div><br>
<a href="/trabalhofinal/formulario_inserir_usuario.php">Novo</a><br><br>

<a href="/trabalhofinal/login_edicao.php">Atualizar Usuário</a><br><br>

<a href="/trabalhofinal/exclusao.php">Excluir</a><br><br>
<?php
// Incluir o arquivo de conexão
require_once 'conexao.php';

// Query para selecionar todos os registros da tabela usuarios
$sql = "SELECT id, nome, /*idade,*/ email FROM usuarios";
$resultado = $conn->query($sql);

// Verificando se há registros retornados pela consulta
if ($resultado->num_rows > 0) {
    // Exibindo os dados de cada registro
    echo "<h2>Lista de Usuários</h2>";
    echo "<ul>";
    while ($row = $resultado->fetch_assoc()) {
        echo "<li>";
        echo "<span class='usuario'>Nome: </span>" . $row["nome"] . "<br>";
        /*echo "<span>Idade: </span>" . $row["idade"] . "<br>";*/
        echo "<span>Email: </span>" . $row["email"] . "<br>";
       /* echo "<span>Status: </span>" . $row["status"];*/
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum usuário cadastrado.";
}

// Fechando conexão com o banco de dados
$conn->close();
?>
</body>
</html>
