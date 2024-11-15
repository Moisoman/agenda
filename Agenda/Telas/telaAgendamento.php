<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['usuarioLogado'])) {
    // Redirect to login page if not logged in
    header('Location: telaLogin.php');
    exit();
}

// Get the logged-in user's data from the session
$usuarioLogado = $_SESSION['usuarioLogado'];
$userId = $usuarioLogado['id']; // Get user ID for further use
$nomeUsuario = $usuarioLogado['nome']; // Get user name

// Database connection and further processing...
$host = 'localhost:3306'; // Your database host
$db = 'agenda'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch clinics from database
$stmt = $conn->prepare("SELECT id_clinica, nm_clinica FROM clinica");
$stmt->execute();
$stmt->bind_result($clinicaId, $clinicaNome);
$clinica = [];

while ($stmt->fetch()) {
    $clinica[] = ['id_clinica' => $clinicaId, 'nm_clinica' => $clinicaNome];
}
$stmt->close();

// Handle form submission for scheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_agendamento'])) {
    $clinicaId = $_POST['clinica'];
    $procedimento = $_POST['procedimento'];
    $dataHora = date('Y-m-d H:i:s');

    // Insert the appointment into the database
    $stmt = $conn->prepare("INSERT INTO agendamentos (usuario_id, clinica_id,dt_agendamento) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userId, $clinicaId, $procedimento, $dataHora);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento realizado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao realizar o agendamento: " . $stmt->error . "');</script>";
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
    <title>Tela de Agendamento</title>
    <link rel="stylesheet" href="telaAgendamento.css">
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<div class="container">
    <div class="opcoes">
        <div class="perfil">
            <span id="usuarioNome">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?></span>
        </div>
        
        <h1>Agendamento</h1>
        
        <form method="POST" action="">
            <label for="clinica">Selecione a clínica:</label>
            <select id="clinica" name="clinica" required>
                <option value="">Selecione uma clínica</option>
                <?php foreach ($clinicas as $clinica): ?>
                    <option value="<?php echo $clinica['id']; ?>">
                        <?php echo htmlspecialchars($clinica['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Date Picker -->
            <label for="data">Selecione a data:</label>
            <input type="text" id="datepicker" name="data" readonly required>
            
            <div class="botoes">
                
                
                <a href="telaPerfil.php">
                <button type="button">Perfil</button>
                </a>
                <button type="submit" name="confirmar_agendamento">CONFIRMAR</button>
            </div>
        </form>
    </div>

    <!-- This will be the calendar that will show when Agendar button is clicked -->
    <div class="calendario" id="calendario" style="display: none;">
        <input type="text" id="datepicker">
    </div>
</div>

<script src="calendario.js"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr
    flatpickr("#datepicker", {
        minDate: "today", // User can't select a date before today
        dateFormat: "Y-m-d", // Format the date as yyyy-mm-dd
        enableTime: false, // Disable time selection, allow only date
        nextArrow: '→', // Arrow to go to the next month
        prevArrow: '←', // Arrow to go to the previous month
    });

    // Toggle calendar visibility when clicking the Agendar button
    document.getElementById('btnAgendar').addEventListener('click', function() {
        const calendario = document.getElementById('calendario');
        // Toggle visibility of the calendar
        if (calendario.style.display === 'none' || calendario.style.display === '') {
            calendario.style.display = 'block';
        } else {
            calendario.style.display = 'none';
        }
    });
</script>

</body>
</html>

