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
$user = 'root'; // Your database username
$pass = ''; // Database password

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch clinics from the database
$stmt = $conn->prepare("SELECT id_clinica, nm_clinica FROM clinica");
$stmt->execute();
$stmt->bind_result($clinicaId, $clinicaNome);
$clinica = [];

while ($stmt->fetch()) {
    $clinica[] = ['id_clinica' => $clinicaId, 'nm_clinica' => $clinicaNome];
}
$stmt->close();

// Fetch the user's agendamentos
$stmt = $conn->prepare("SELECT ag.id, ag.data_hora, c.nm_clinica, u.nome AS paciente_nome, ag.ativo 
                        FROM agendamentos ag 
                        JOIN clinica c ON ag.clinica_id = c.id_clinica 
                        JOIN usuarios u ON ag.usuario_id = u.id 
                        WHERE ag.usuario_id = ? 
                        ORDER BY ag.data_hora DESC");
$stmt->bind_param("i", $userId); // Bind user ID to the query
$stmt->execute();
$result = $stmt->get_result(); // Get the result of the query

// Handle form submission for scheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_agendamento'])) {
    $clinicaId = $_POST['clinica'];
    $dataHora = $_POST['data']; // Get the selected date from the form

    // Insert the appointment into the database
    $stmt = $conn->prepare("INSERT INTO agendamentos (usuario_id, clinica_id, data_hora) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $userId, $clinicaId, $dataHora);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento realizado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao realizar o agendamento: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_agendamento'])) {
    $agendamentoId = $_POST['agendamento_id']; // Get the appointment ID to cancel

    // Prepare the SQL query to delete the agendamento
    $stmt = $conn->prepare("DELETE FROM agendamentos WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $agendamentoId, $userId); // Bind the agendamento ID and user ID
    if ($stmt->execute()) {
        echo "<script>alert('Agendamento cancelado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cancelar o agendamento: " . $stmt->error . "');</script>";
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

    <style>
        /* Base Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .opcoes {
            margin-bottom: 30px;
        }

        .perfil {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }

        /* Form Styling */
        form {
            margin-bottom: 30px;
        }

        select, input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="button"], button[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        button[type="button"]:hover, button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Styling for 'Seus Agendamentos' Section */
        .agendamentos {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .agendamentos table {
            width: 100%;
            border-collapse: collapse;
        }

        .agendamentos th, .agendamentos td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .agendamentos th {
            background-color: #007bff;
            color: white;
        }

        .agendamentos tbody tr:hover {
            background-color: #f1f1f1;
        }

        .agendamentos tbody tr {
            transition: background-color 0.3s ease;
        }

        .card {
            padding: 20px;
            margin: 15px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card .info {
            display: flex;
            justify-content: space-between;
        }

        .card .info span {
            font-size: 16px;
            color: #555;
        }

        .card .info .date {
            font-weight: bold;
            color: #007bff;
        }

        .card .info .clinica {
            font-weight: bold;
            color: #28a745;
        }

    </style>
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
                <?php foreach ($clinica as $cl): ?>
                    <option value="<?php echo $cl['id_clinica']; ?>">
                        <?php echo htmlspecialchars($cl['nm_clinica']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Date Picker -->
            <label for="data">Selecione a data e hora:</label>
            <input type="text" id="datepicker" name="data" readonly required>
            
            <div class="botoes">
                <a href="telaPerfil.php">
                <button type="button">Perfil</button>
                </a>
                <button type="submit" name="confirmar_agendamento">CONFIRMAR</button>
            </div>
        </form>

        <!-- Display User's Agendamentos -->
        <div class="agendamentos">
            <h2>Seus Agendamentos</h2>
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data e Hora</th>
                            <th>Clínica</th>
                            <th>Paciente</th>
                            <th>SITUAÇÃO</th> <!-- New column -->
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['data_hora'])); ?></td>
                                <td><?php echo htmlspecialchars($row['nm_clinica']); ?></td>
                                <td><?php echo htmlspecialchars($row['paciente_nome']); ?></td>
                                <td>
                                    <?php echo $row['ativo'] == 1 ? 'CONFIRMADA' : 'PENDENTE'; ?>
                                </td>
                                <td>
                                    <!-- Cancel Button Form -->
                                    <form method="POST" action="">
                                        <input type="hidden" name="agendamento_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="cancelar_agendamento" onclick="return confirm('Você tem certeza que deseja cancelar este agendamento?');">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Você não tem nenhum agendamento.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="calendario.js"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr
    flatpickr("#datepicker", {
        minDate: "today", // User can't select a date before today
        dateFormat: "Y-m-d H:i", // Format the date as yyyy-mm-dd HH:mm
        enableTime: true, // Enable time selection along with date
        nextArrow: '→', // Arrow to go to the next month
        prevArrow: '←', // Arrow to go to the previous month
    });
</script>

</body>
</html>
