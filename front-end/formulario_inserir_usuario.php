<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Usuário</title>
    <link rel="stylesheet" href="telaCadastro.css">
</head>
<body>
<a href="index.php">Home</a><br><br>

<h2>Formulário de Inserção de Usuário</h2>

<form action="inserir_usuario.php" method="post">
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" required><br><br>
   
   <!-- <label for="idade">Idade:</label><br>
    <input type="number" id="idade" name="idade" required><br><br> -->

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
   
    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <label for="confirma_senha">Confirme a Senha:</label><br>
    <input type="password" id="confirma_senha" name="confirma_senha" required><br><br>
    
    <label for="telefone">Telefone:</label><br>
    <input type="text" id="telefone" name="telefone" required><br><br>

    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const senha = document.getElementById('senha').value;
        const confirmaSenha = document.getElementById('confirma_senha').value;
        
        if (senha !== confirmaSenha) {
            alert('As senhas não coincidem. Por favor, tente novamente.');
            event.preventDefault(); // Impede o envio do formulário
        }
    });
    </script>

    </select><br><br>
    
    <input type="submit" value="Inserir Usuário">
</form>

</body>
</html>
