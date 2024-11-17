<?php
// Start the PHP session (optional if you want session tracking on this page)
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos - Nossa Empresa</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can link your custom stylesheet here -->
    <style>
        /* Base Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 36px;
            color: #007bff;
        }

        header p {
            font-size: 18px;
            color: #555;
        }

        .section-title {
            font-size: 28px;
            margin-top: 40px;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .content ul {
            list-style-type: square;
            margin-left: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Quem Somos</h1>
        <p>Conheça nossa missão, visão e valores.</p>
    </header>

    <section class="content">
        <div class="section-title">Nossa Missão</div>
        <p>A nossa missão é fornecer soluções inovadoras para nossos clientes, com foco em qualidade, excelência e atendimento personalizado. Além disso, buscamos criar um ambiente confortável e eficiente para clínicas e profissionais de odontologia, facilitando o melhor gerenciamento das operações clínicas.</p>

        <div class="section-title">Nossa Visão</div>
        <p>Ser reconhecido como líder no mercado, fornecendo soluções inteligentes e sustentáveis que transformem a vida das pessoas. Queremos ser uma empresa que inspira confiança, inovação e valores sólidos.</p>

        <div class="section-title">Nossos Valores</div>
        <ul>
            <li><strong>Comprometimento:</strong> Nos dedicamos com seriedade e responsabilidade em tudo que fazemos.</li>
            <li><strong>Inovação:</strong> Buscamos sempre inovar, encontrar novas soluções e melhorar constantemente, levando em consideração a opnião dos nossos clientes.</li>
            <li><strong>Ética:</strong> Atuamos com integridade, transparência e respeito, criando um ambiente de confiança.</li>
            <li><strong>Responsabilidade Social:</strong> Acreditamos no impacto positivo que podemos gerar na sociedade, alcançando uma ampla parcela da população e promovendo uma melhoria significativa na qualidade de vida.</li>
        </ul>

        <div class="section-title">Sobre a Plataforma de Agendamento</div>
        <p>Nos últimos anos, a demanda por serviços de saúde bucal tem crescido significativamente, refletindo uma maior conscientização sobre a importância da higiene oral e dos cuidados dentários. De acordo com dados da Organização Mundial da Saúde, a saúde bucal afeta não apenas a qualidade de vida, mas também impacta o indivíduo socialmente. Entretanto, o acesso a consultas odontológicas ainda enfrenta desafios, como longas filas de espera e dificuldades de agendamento.</p>

        <p>Com o objetivo de transformar essa realidade, estamos desenvolvendo uma plataforma de agendamento de consultas odontológicas online. Nosso propósito é criar uma solução que simplifique o processo de marcação, priorizando a experiência do paciente e proporcionando um gerenciamento mais eficiente para os profissionais da área. Por meio de um sistema de priorização, pretendemos garantir que pacientes com necessidades urgentes recebam atendimento mais rapidamente, levando em consideração os sintomas que os usuários informaram durante o atendimento, contribuindo para um cuidado mais ágil e eficaz.</p>

        <p>Primeiramente, a ideia surgiu como uma ferramenta de priorização similar ao JIRA para desenvolvimento de softwares. Entretanto, ao aprofundar-se na ideia, percebeu-se que seria uma ótima ferramenta para o agendamento de consultas, focando em consultas odontológicas, com a intenção de ter um escopo menor.</p>

        <p>Para compreender a relevância da priorização de consultas, foi considerada a crescente demanda por esse serviço e o impacto na saúde de uma população, com o objetivo de otimizar o tempo do paciente e permitir que situações de emergência se resolvam de maneira eficiente, assim melhorando a experiência do paciente e evitando que ocorram complicações, como por exemplo a retirada de dentes, hemorragias e infecções que tragam risco para a vida.</p>
    </section>

</div>

<footer>
    <p>&copy; 2024 Nossa Empresa. Todos os direitos reservados.</p>
</footer>

</body>
</html>
