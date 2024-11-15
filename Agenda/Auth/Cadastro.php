<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastramento</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="../Telas/telaCadastro.css">
</head>
<body>

    
    <div class="container">
        <!-- Título do formulário -->
        <h2>Cadastro de Cliente</h2>

        <!-- Início do formulário -->
        <form action="inserir_usuario.php" method="POST">

            
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            
            <div class="form-group">
                <label for="confirmSenha">Confirme Sua Senha:</label>
                <input type="password" id="confirmSenha" name="confirmSenha" required>
            </div>

           
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" required>
            </div>

            
            <div class="form-group">
                <button type="submit" value="Cadastrar">Registrar</button>
            </div>

        </form>
        
    </div>

</body>
</html>
