function showClinicDetails(clinic) {
    const detailsContent = document.getElementById('details-content');
    let htmlContent = '';
    
    if (clinic === 'clinic1') {
        htmlContent = "<h3>Clínica A</h3>" +
                      "<button class='btn-agendar'>Agendar</button>" +
                      "<button class='btn-info' onclick='toggleInfo(\"info1\")'>Info</button>" +
                      "<div id='info1' class='info' style='display: none;'>" +
                          "<p>Procedimentos: Limpeza, Restauração, Extração</p>" +
                          "<div class='avaliacao'>" +
                              "<h3>Avaliações</h3>" +
                              "<form action='avaliar.php' method='POST'>" +
                                  "<label for='estrela'>Avalie:</label>" +
                                  "<select name='estrela' id='estrela'>" +
                                      "<option value='1'>1 estrela</option>" +
                                      "<option value='2'>2 estrelas</option>" +
                                      "<option value='3'>3 estrelas</option>" +
                                      "<option value='4'>4 estrelas</option>" +
                                      "<option value='5'>5 estrelas</option>" +
                                  "</select>" +
                                  "<textarea name='comentario' placeholder='Deixe seu comentário...'></textarea>" +
                                  "<button type='submit'>Enviar Avaliação</button>" +
                              "</form>" +
                          "</div>" +
                      "</div>";
    } else if (clinic === 'clinic2') {
        htmlContent = "<h3>Clínica B</h3>" +
                      "<button class='btn-agendar'>Agendar</button>" +
                      "<button class='btn-info' onclick='toggleInfo(\"info2\")'>Info</button>" +
                      "<div id='info2' class='info' style='display: none;'>" +
                          "<p>Procedimentos: Consulta, Exame, Vacinação</p>" +
                          "<div class='avaliacao'>" +
                              "<h3>Avaliações</h3>" +
                              "<form action='avaliar.php' method='POST'>" +
                                  "<label for='estrela'>Avalie:</label>" +
                                  "<select name='estrela' id='estrela'>" +
                                      "<option value='1'>1 estrela</option>" +
                                      "<option value='2'>2 estrelas</option>" +
                                      "<option value='3'>3 estrelas</option>" +
                                      "<option value='4'>4 estrelas</option>" +
                                      "<option value='5'>5 estrelas</option>" +
                                  "</select>" +
                                  "<textarea name='comentario' placeholder='Deixe seu comentário...'></textarea>" +
                                  "<button type='submit'>Enviar Avaliação</button>" +
                              "</form>" +
                          "</div>" +
                      "</div>";
    }

    detailsContent.innerHTML = htmlContent;
    document.getElementById('clinic-details').style.display = 'block';
}

function hideClinicDetails() {
    document.getElementById('clinic-details').style.display = 'none';
}

function toggleInfo(infoId) {
    const infoDiv = document.getElementById(infoId);
    infoDiv.style.display = infoDiv.style.display === 'none' ? 'block' : 'none';
}
