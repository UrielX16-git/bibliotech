$(document).ready(function () {
    // Configuración global de colores
    Chart.defaults.color = '#ffffff';
    Chart.defaults.borderColor = '#444444';

    const colors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)'
    ];

    // Descargas por Tipo
    $.get('../backend/stats-api.php?metric=tipo', function (data) {
        const labels = data.map(item => item.Tipo);
        const values = data.map(item => item.total);

        new Chart(document.getElementById('chartTipo'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors
                }]
            }
        });
    });

    // Descargas por Hora
    $.get('../backend/stats-api.php?metric=hora', function (data) {
        const hours = Array.from({ length: 24 }, (_, i) => i);
        const values = new Array(24).fill(0);

        data.forEach(item => {
            values[parseInt(item.hora)] = parseInt(item.total);
        });

        new Chart(document.getElementById('chartHora'), {
            type: 'line',
            data: {
                labels: hours.map(h => h + ':00'),
                datasets: [{
                    label: 'Descargas',
                    data: values,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });

    // Top Papers
    $.get('../backend/stats-api.php?metric=top-papers', function (data) {
        const labels = data.map(item => item.Nombre);
        const values = data.map(item => item.total);

        new Chart(document.getElementById('chartTopPapers'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Descargas',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });

    // Top Usuarios
    $.get('../backend/stats-api.php?metric=top-users', function (data) {
        const labels = data.map(item => item.nombre);
        const values = data.map(item => item.total);

        new Chart(document.getElementById('chartTopUsers'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Descargas',
                    data: values,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
});
