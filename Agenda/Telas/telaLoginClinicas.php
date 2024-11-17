<?php
session_start();
$host = 'localhost:3306'; 
$db = 'agenda'; 
$user = 'root'; 
$pass = ''; 

if (isset($_SESSION['usuarioLogado'])) {
    unset($_SESSION['usuarioLogado']); // Log out the user
}
// Database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = $_POST['cnpj']; // Now we are using CNPJ instead of email
    $senha = $_POST['senha'];

    // Validate login credentials for clinics
    $stmt = $conn->prepare("SELECT id_clinica, nm_clinica, cnpj, senha FROM clinica WHERE cnpj = ?");
    $stmt->bind_param("s", $cnpj); 
    $stmt->execute();
    $stmt->store_result();
    
    // Check if a matching clinic exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($clinicId, $clinicName, $clinicCNPJ, $storedHashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify(trim($senha), trim($storedHashedPassword))) {
            // Password is correct
            $_SESSION['clinicaLogada'] = [
                'id_clinica' => $clinicId,
                'nm_clinica' => $clinicName,
                'cnpj' => $clinicCNPJ,
            ];
            header('Location: ../Auth/index.php');
            exit;
        } else {
            // Invalid password
            $errorMessage = "Senha inválida!";
        }
        
    } else {
        // Invalid CNPJ
        $errorMessage = "CNPJ não encontrado!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 50px;
        }
        .login-container {
            width: 400px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login - Clínica</h2>
    
    <?php if (isset($errorMessage)): ?>
        <div class="error-message"><?= $errorMessage; ?></div>
    <?php endif; ?>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" required maxlength=14/>
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required />
        </div>
        <div class="form-group">
            <input type="submit" value="Entrar" />
        </div>
    </form>
    <p>Não tem uma conta? <a href="telaCadastroClinica.php">Criar uma conta</a></p>
    <p>Voltar para o inicio <a href="../Auth/index.php">Home</a></p>
</div>

</body>
</html>
