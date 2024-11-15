<?php
session_start(); // Start the session

// Include the database connection (update with your actual connection file)
include('conexao.php'); 

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validate user credentials
    $usuario = getUserFromDatabase($email, $senha);

    if ($usuario) {
        // Store user data in session after successful login
        $_SESSION['usuarioLogado'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'imagem' => $usuario['imagem'] // Add any other user details you need
        ];
        // Redirect to the home page or profile page
        header('Location: index.php'); // Or wherever you want to send the user
        exit;
    } else {
        // Invalid credentials
        echo "Usuário ou senha inválidos!";
    }
}

// Function to fetch user from the database
function getUserFromDatabase($email, $senha) {
    global $conn;  // Assuming $conn is your database connection

    // Prepare the SQL query to fetch user details based on the email
    $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("s", $email);

        // Execute the query
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($id, $nome, $emailDb, $senhaDb);

        // Fetch the result
        if ($stmt->fetch()) {
            // Check if the password matches (use password_verify for hashed passwords)
            if (password_verify($senha, $senhaDb)) {
                // Return user data as an associative array
                return [
                    'id' => $id,
                    'nome' => $nome,
                    'email' => $emailDb,
                ];
            }
        }

        // Close the statement and return false if user not found or password doesn't match
        $stmt->close();
    }

    // If no user found or password mismatch, return false
    return false;
}
?>
