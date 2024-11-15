// Exemplo de agendamentos
const agendamentos = [
    {
        procedimento: "Consulta de Rotina",
        data: "25/10/2024",
        hora: "14:00",
        profissional: "Dr. João Silva",
        observacoes: "Chegar 15 minutos antes."
    },
    {
        procedimento: "Limpeza Dental",
        data: "30/10/2024",
        hora: "10:30",
        profissional: "Dra. Maria Oliveira",
        observacoes: "Não comer nada antes da consulta."
    }
];

const listaAgendamentos = document.querySelector(".lista-agendamentos");

agendamentos.forEach(agendamento => {
    const agendamentoDiv = document.createElement("div");
    agendamentoDiv.classList.add("agendamento");
    
    agendamentoDiv.innerHTML = `
        <h2>${agendamento.procedimento}</h2>
        <p><strong>Data:</strong> ${agendamento.data}</p>
        <p><strong>Hora:</strong> ${agendamento.hora}</p>
        <p><strong>Profissional:</strong> ${agendamento.profissional}</p>
        <p><strong>Observações:</strong> ${agendamento.observacoes}</p>
    `;
    
    listaAgendamentos.appendChild(agendamentoDiv);
});
