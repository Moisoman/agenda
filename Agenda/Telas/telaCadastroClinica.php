<?php
session_start();
$host = 'localhost:3306'; // Your database host
$db = 'agenda'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj']; // CNPJ instead of email
    $senha = $_POST['senha'];

    // Check if the CNPJ already exists in the database
    $stmt = $conn->prepare("SELECT id FROM clinicas WHERE cnpj = ?");
    $stmt->bind_param("s", $cnpj);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // CNPJ already exists
        $errorMessage = "Este CNPJ já está registrado!";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        // Register new clinic with hashed password
        $stmt = $conn->prepare("INSERT INTO clinicas (nome, cnpj, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $cnpj, $hashedPassword); // Use hashed password here
        if ($stmt->execute()) {
            $successMessage = "Clínica registrada com sucesso! Você pode fazer login agora.";
        } else {
            $errorMessage = "Erro ao registrar a clínica. Tente novamente.";
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clínica</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            color: #fff;
            text-align: center;
        }

        .register-container h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
            color: #fff;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            color: #333;
            transition: all 0.3s ease-in-out;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 10px rgba(72, 180, 97, 0.6);
        }

        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .form-group input[type="submit"]:hover {
            background-color: #388E3C;
        }

        .error-message, .success-message {
            font-size: 16px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            display: block;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        p {
            font-size: 16px;
            margin-top: 15px;
            color: #fff;
        }

        p a {
            color: #ffeb3b;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Cadastro de Clínica</h2>

    <?php if (isset($errorMessage)): ?>
        <div class="error-message"><?= $errorMessage; ?></div>
    <?php elseif (isset($successMessage)): ?>
        <div class="success-message"><?= $successMessage; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nome">Nome da Clínica</label>
            <input type="text" id="nome" name="nome" required />
        </div>
        <div class="form-group">
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" required />
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required />
        </div>
        <div class="form-group">
            <input type="submit" value="Cadastrar" />
        </div>
    </form>

    <p>Já tem uma conta? <a href="telaLoginClinica.php">Faça login</a></p>
</div>

</body>
</html>
