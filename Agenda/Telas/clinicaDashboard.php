<?php
session_start(); // Start the session

// Check if the clinic is logged in
if (!isset($_SESSION['clinicaLogada'])) {
    header("Location: telaLoginClinicas.php");
    exit;
}

// Get the clinic details from the session
$clinicaId = $_SESSION['clinicaLogada']['id_clinica'];
$clinicaName = $_SESSION['clinicaLogada']['nm_clinica'];

// Database connection
$host = 'localhost:3306';
$db = 'agenda';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle confirming an agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_agendamento'])) {
    $agendamentoId = $_POST['agendamento_id'];

    $stmt = $conn->prepare("UPDATE agendamentos SET ativo = 1 WHERE id = ? AND clinica_id = ?");
    $stmt->bind_param("ii", $agendamentoId, $clinicaId);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento confirmado com sucesso!'); window.location.href = 'clinicaDashboard.php';</script>";
    } else {
        echo "<script>alert('Erro ao confirmar o agendamento: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Handle deleting an agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_agendamento'])) {
    $agendamentoId = $_POST['agendamento_id'];

    $stmt = $conn->prepare("DELETE FROM agendamentos WHERE id = ? AND clinica_id = ?");
    $stmt->bind_param("ii", $agendamentoId, $clinicaId);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento deletado com sucesso!'); window.location.href = 'clinicaDashboard.php';</script>";
    } else {
        echo "<script>alert('Erro ao deletar o agendamento: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch all available agendamentos for the respective clinic (not yet confirmed, i.e., where ativo = 0)
$sql = "SELECT ag.id, ag.data_hora, u.nome AS paciente_nome, c.nm_clinica AS clinica_nome
        FROM agendamentos ag
        JOIN usuarios u ON ag.usuario_id = u.id
        JOIN clinica c ON ag.clinica_id = c.id_clinica
        WHERE ag.ativo = 0 AND ag.clinica_id = ?";  // Filter by clinic ID

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clinicaId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all confirmed agendamentos for the respective clinic (where ativo = 1)
$sql_confirmed = "SELECT ag.id, ag.data_hora, u.nome AS paciente_nome, c.nm_clinica AS clinica_nome
                  FROM agendamentos ag
                  JOIN usuarios u ON ag.usuario_id = u.id
                  JOIN clinica c ON ag.clinica_id = c.id_clinica
                  WHERE ag.ativo = 1 AND ag.clinica_id = ?";  // Filter by clinic ID

$stmt_confirmed = $conn->prepare($sql_confirmed);
$stmt_confirmed->bind_param("i", $clinicaId);
$stmt_confirmed->execute();
$result_confirmed = $stmt_confirmed->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Clínica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .home-btn, .logout-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .home-btn:hover, .logout-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Dashboard - Clínica: <?= htmlspecialchars($clinicaName) ?></h1>
        <a href="../Auth/index.php">
            <button class="home-btn">Home</button>
        </a>
        <a href="../Auth/logoutUsuario.php">
            <button class="logout-btn">Logout</button>
        </a>
    </div>

    <!-- Main container -->
    <div class="container">
        <h2>Agendamentos Disponíveis</h2>

        <!-- If there are no agendamentos, display a message -->
        <?php if ($result->num_rows === 0): ?>
            <p>Não há agendamentos disponíveis no momento.</p>
        <?php else: ?>
             <!-- Table for displaying agendamentos -->
             <table>
      <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Data e Hora</th>
            <th>Clínica</th>
            <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['paciente_nome']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['data_hora'])) ?></td>
                <td><?= htmlspecialchars($row['clinica_nome']) ?></td>
                <td>
                    <!-- Form for "Cancelar" -->
                    <form method="POST" action="">
                        <input type="hidden" name="agendamento_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn" name="delete_agendamento">Cancelar</button>
                    </form>

                    <!-- Form for "Confirmar" -->
                    <form method="POST" action="">
                        <input type="hidden" name="agendamento_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn" name="confirmar_agendamento">Confirmar</button>
                    </form>

                    <button class="btn">Ver Detalhes</button>
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
     </table>

        <?php endif; ?>
    </div>
    <!-- Section for Confirmed Agendamentos -->
<div class="container">
    <h2>Agendamentos Confirmados</h2>

    <!-- If there are no confirmed agendamentos, display a message -->
    <?php if ($result_confirmed->num_rows === 0): ?>
        <p>Não há agendamentos confirmados.</p>
    <?php else: ?>
        <!-- Table for displaying confirmed agendamentos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Data e Hora</th>
                    <th>Clínica</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_confirmed->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['paciente_nome']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['data_hora'])) ?></td>
                        <td><?= htmlspecialchars($row['clinica_nome']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>


</body>
</html>

