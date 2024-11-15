// Função para gerar o calendário
function gerarCalendario() {
    const calendario = document.getElementById("calendario");
    const dataAtual = new Date();
    const ano = dataAtual.getFullYear();
    const mes = dataAtual.getMonth(); // 0 (Janeiro) a 11 (Dezembro)
    
    // Determina o primeiro dia do mês
    const primeiroDia = new Date(ano, mes, 1).getDay(); // 0 (Domingo) a 6 (Sábado)
    
    // Determina o número de dias no mês
    const diasNoMes = new Date(ano, mes + 1, 0).getDate(); // Dias no mês atual
    
    // Limpa o conteúdo existente do calendário
    calendario.innerHTML = "";

    // Adiciona os nomes dos dias da semana
    const diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
    diasDaSemana.forEach(dia => {
        const elementoDiaDaSemana = document.createElement("div");
        elementoDiaDaSemana.classList.add("dia");
        elementoDiaDaSemana.textContent = dia;
        calendario.appendChild(elementoDiaDaSemana);
    });

    // Adiciona os espaços em branco antes do primeiro dia do mês
    for (let i = 0; i < primeiroDia; i++) {
        const elementoEspaco = document.createElement("div");
        calendario.appendChild(elementoEspaco); // Espaços em branco
    }

    // Cria os dias do mês
    for (let dia = 1; dia <= diasNoMes; dia++) {
        const elementoDia = document.createElement("div");
        elementoDia.classList.add("dia");
        elementoDia.textContent = dia;

        // Adiciona evento de clique para permitir a seleção do dia
        elementoDia.addEventListener('click', () => {
            // Remove a classe de seleção dos outros dias
            const dias = document.querySelectorAll(".dia-selecionado");
            dias.forEach(d => d.classList.remove("dia-selecionado"));
            
            // Adiciona a classe de seleção ao dia clicado
            elementoDia.classList.add("dia-selecionado");
        });

        calendario.appendChild(elementoDia);
    }

    // Exibe o calendário como uma grade
    calendario.style.display = "grid";
}

// Evento de clique no botão "Agendar"
document.getElementById("btnAgendar").addEventListener("click", gerarCalendario);
