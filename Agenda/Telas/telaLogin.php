<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="telaCadastro.css">
</head>
<body>

    <div class="container">
        <h2>Login de Paciente</h2>

        <form action="../Auth/loginUsuario.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-group">
                <button type="submit">Entrar</button>
            </div>

            <div class="form-group">
                <p>Ainda não tem uma conta? <a href="/agenda/Agenda/Auth/Cadastro.php">Cadastre-se</a></p>
            </div>
        </form>
    </div>

</body>
</html>
