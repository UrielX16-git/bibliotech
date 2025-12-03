$(document).ready(function () {
    console.log('Bibliotech Iniciada');

    // LISTAR PAPERS
    listarPapers();

    function listarPapers() {
        $.ajax({
            url: './backend/paper-list.php',
            type: 'GET',
            success: function (response) {
                let papers = JSON.parse(response);
                let template = '';
                papers.forEach(paper => {
                    let imagenPath = paper.Imagen.replace('../', '');
                    template += `
                        <tr paperId="${paper.ID}">
                            <td>${paper.Nombre}</td>
                            <td>${paper.Autores}</td>
                            <td>${paper.Fecha}</td>
                            <td>${paper.Explicacion}</td>
                            <td><img src="${imagenPath}" alt="${paper.Nombre}" class="paper-img"></td>
                        </tr>
                    `;
                });
                $('#papers').html(template);
            }
        });
    }

    // EVITAR EL ENVIO DEL FORMULARIO
    $('form').submit(function (e) {
        e.preventDefault();
    });

    // BUSQUEDA
    $('#search').keyup(function (e) {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/paper-search.php',
                type: 'GET',
                data: { search: search },
                success: function (response) {
                    let papers = JSON.parse(response);
                    let template = '';
                    let template_bar = '';

                    papers.forEach(paper => {
                        let imagenPath = paper.Imagen.replace('../', '');
                        template += `
                            <tr paperId="${paper.ID}">
                                <td>${paper.Nombre}</td>
                                <td>${paper.Autores}</td>
                                <td>${paper.Fecha}</td>
                                <td>${paper.Explicacion}</td>
                                <td><img src="${imagenPath}" alt="${paper.Nombre}" class="paper-img"></td>
                            </tr>
                        `;

                        template_bar += `
                            <li>${paper.Nombre}</li>
                        `;
                    });

                    $('#paper-result').removeClass('d-none');
                    $('#container').html(template_bar);
                    $('#papers').html(template);
                }
            });
        } else {
            $('#paper-result').addClass('d-none');
            listarPapers(); // Volver a listar todos si no hay búsqueda
        }
    });
});
