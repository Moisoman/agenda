<?php

$host = "localhost:3306"; // Endereço do servidor MySQL
$usuario = "root"; // Usuário do banco de dados
$senha = ""; // Senha do banco de dados
$banco = "trabalhofinal"; // Nome do banco de dados

// Criando conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

?>
