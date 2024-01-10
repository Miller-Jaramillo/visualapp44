<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 grid grid-cols-2">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Clase de Accidente por género</h2>
       </header>
<!-- Agrega un elemento select para seleccionar el registro -->



    <div id="dashboard-pie-chart-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-pie" width="300" height="280"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ... (sin cambios en esta parte) ... -->


<!-- ... (sin cambios en esta parte) ... -->
<script>
    document.addEventListener('livewire:load', function () {
        const ctx = document.getElementById("chart-pie").getContext("2d");
        const labels = @json($labels);
        const counts = @json($counts);
        let pieChart;

        // Agregar oyente de eventos Livewire para actualizar el gráfico
        Livewire.on('updateChart', (registroId) => {
            updateChart(registroId);
        });

        // Función para generar un color aleatorio
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Función para inicializar o actualizar el gráfico
        function initializeOrUpdateChart(registroId) {
            const randomColors = Array.from({ length: counts.length }, () => getRandomColor());

            if (!pieChart) {
                // Inicializar el gráfico si aún no existe
                pieChart = new Chart(ctx, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: randomColors,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            }
                        },
                        hoverOffset: 8,
                    },
                });
            } else {
                // Actualizar solo los datos del gráfico sin recrearlo
                pieChart.data.labels = labels;
                pieChart.data.datasets[0].data = counts;
                pieChart.data.datasets[0].backgroundColor = randomColors;
                pieChart.update();
            }

            // Agregar leyendas al elemento legend
            const legend = document.getElementById('dashboard-pie-chart-legend');
            legend.innerHTML = ''; // Limpiar las leyendas antes de agregar las nuevas
            labels.forEach((label, index) => {
                const color = randomColors[index];
                const listItem = document.createElement('li');
                listItem.innerHTML = `<span style="display:inline-block;width:15px;height:15px;background-color:${color};margin-right:5px;"></span>${label}: ${counts[index]} &nbsp;&nbsp;`;
                legend.querySelector('ul').appendChild(listItem);
            });
        }

        // Función para actualizar el gráfico con el nuevo registro seleccionado
        function updateChart(registroId) {
            if (registroId) {
                // Consultar datos específicos para el nuevo registro seleccionado
                Livewire.emit('loadData', registroId);
            } else {
                // Consultar datos generales si no hay registro seleccionado
                Livewire.emit('loadData', null);
            }
        }

        // Llamar a la función de inicialización o actualización
        initializeOrUpdateChart(@json($selectedRegistroId));
    });
</script>
