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
                        <div class="paper-card" paperId="${paper.ID}">
                            <div class="row">
                                <div class="col-md-3 paper-img-container">
                                    <img src="${imagenPath}" alt="${paper.Nombre}" class="paper-img">
                                </div>
                                <div class="col-md-9 paper-content">
                                    <div class="paper-header">
                                        <h4 class="paper-title">${paper.Nombre}</h4>
                                        <span class="paper-date">${paper.Fecha}</span>
                                    </div>
                                    <div class="paper-authors">
                                        Autores: ${paper.Autores}
                                    </div>
                                        ${paper.Explicacion}
                                    </div>
                                    <a href="${paper.Archivo.replace('../', '')}" class="btn btn-outline-info btn-sm mt-3" target="_blank" download>
                                        Descargar PDF
                                    </a>
                                    ${(typeof userRole !== 'undefined' && userRole === 'admin') ?
                            `<button class="paper-delete btn btn-danger btn-sm mt-3 ml-2" paperId="${paper.ID}">
                                            Eliminar
                                        </button>` : ''
                        }
                                </div>
                            </div>
                        </div>
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


                    if (papers.length === 0) {
                        template = '<div class="alert alert-warning" role="alert" style="text-align: center; margin-top: 20px;">No se ha encontrado el paper...</div>';
                    } else {
                        papers.forEach(paper => {
                            let imagenPath = paper.Imagen.replace('../', '');
                            template += `
                                <div class="paper-card" paperId="${paper.ID}">
                                    <div class="row">
                                        <div class="col-md-3 paper-img-container">
                                            <img src="${imagenPath}" alt="${paper.Nombre}" class="paper-img">
                                        </div>
                                        <div class="col-md-9 paper-content">
                                            <div class="paper-header">
                                                <h4 class="paper-title">${paper.Nombre}</h4>
                                                <span class="paper-date">${paper.Fecha}</span>
                                            </div>
                                            <div class="paper-authors">
                                                Autores: ${paper.Autores}
                                            </div>
                                                ${paper.Explicacion}
                                            </div>
                                            <a href="${paper.Archivo.replace('../', '')}" class="btn btn-outline-info btn-sm mt-3" target="_blank" download>
                                                Descargar PDF
                                            </a>
                                            ${(typeof userRole === 'admin') ?
                                    `<button class="paper-delete btn btn-danger btn-sm mt-3 ml-2" paperId="${paper.ID}">
                                                    Eliminar
                                                </button>` : ''
                                }
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }


                    $('#papers').html(template);
                }
            });
        } else {

            listarPapers(); // Volver a listar todos si no hay búsqueda
        }
    });

    // ELIMINAR PAPER
    $(document).on('click', '.paper-delete', function () {
        if (confirm('¿Estás seguro de que deseas eliminar este paper?')) {
            let element = $(this)[0].parentElement.parentElement.parentElement;
            let id = $(this).attr('paperId');
            $.post('./backend/paper-delete.php', { id: id }, function (response) {
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    listarPapers();
                } else {
                    alert(data.message);
                }
            });
        }
    });
});
