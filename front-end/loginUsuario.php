<?php
session_start();


$host = 'localhost:3306'; 
$dbname = 'trabalhofinal';
$user = 'root'; 
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Verificando se o usuário existe e se a senha está correta
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($email, $senha);
    // Verifique se o usuário foi encontrado
    if ($usuario) {
        // Verificando a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido
            $_SESSION['usuario'] = $email;
            $_SESSION['usuario_id'] = $usuario['id'];
            header('Location: telaAgendamento.php');
            exit();
        } else {
            // Senha incorreta
            echo "<script>alert('Email ou senha incorretos. Tente novamente.');</script>";
            echo "<script>window.location.href='telaLogin.php';</script>";
        }
    } else {
        // Usuário não encontrado
        echo "<script>alert('Email ou senha incorretos. Tente novamente.');</script>";
        echo "<script>window.location.href='telaLogin.php';</script>";
    }
}
?>
