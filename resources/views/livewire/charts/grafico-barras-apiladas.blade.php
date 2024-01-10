<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfico de Barras Apiladas</h2>
    </header>
    <div id="dashboard-stacked-bar-chart-legend" class="px-5 py-3">
        <!-- Icono de ojo -->
        <button id="toggleLegendBtn" class="text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">

             <div class="grid grid-cols-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                  </svg>

                  <x-label>Informacion</x-label>
             </div>
        </button>
        <ul id="legendList" class="flex flex-wrap" style="display: none;"></ul>
    </div>
    <div class="grow">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-stacked-bars" width="595" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById("chart-stacked-bars").getContext("2d");
        const data = {!! json_encode($data) !!};

        // Organizar los datos por tipo de víctima
        const groupedData = groupBy(data, 'tipo_victima');

        // Configuración del gráfico de barras apiladas
        const stackedBarChartConfig = {
            type: 'bar',
            data: {
                labels: [...new Set(data.map(item => item.clase_accidente))],
                datasets: Object.keys(groupedData).map((tipoVictima, index) => ({
                    label: tipoVictima,
                    data: data.filter(item => item.tipo_victima === tipoVictima).map(item => item.total),
                    backgroundColor: getRandomColor(),
                })),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',  // No mostrar la leyenda aquí, se agregará manualmente
                    },
                },

                hoverOffset: 8,
            },
        };

        new Chart(ctx, stackedBarChartConfig);

        const legendList = document.getElementById('legendList');
        const toggleLegendBtn = document.getElementById('toggleLegendBtn');

        // Agregar leyendas al elemento legend
        Object.keys(groupedData).forEach((tipoVictima, index) => {
            const color = stackedBarChartConfig.data.datasets[index].backgroundColor;
            const listItem = document.createElement('li');
            listItem.innerHTML = `<span style="display:inline-block;width:15px;height:15px;background-color:${color};margin-right:5px;"></span>${tipoVictima}: ${groupedData[tipoVictima].length} &nbsp;&nbsp;`;
            legendList.appendChild(listItem);
        });

        // Función para generar un color aleatorio
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
        }

        // Función para agrupar datos por una propiedad específica
        function groupBy(arr, key) {
            return arr.reduce((acc, obj) => {
                const property = obj[key];
                acc[property] = acc[property] || [];
                acc[property].push(obj);
                return acc;
            }, {});
        }

        // Manejar el clic en el botón de alternar leyenda
        toggleLegendBtn.addEventListener('click', function() {
            const legendDisplayStyle = legendList.style.display;
            legendList.style.display = legendDisplayStyle === 'none' ? 'block' : 'none';
        });
    });
</script>
