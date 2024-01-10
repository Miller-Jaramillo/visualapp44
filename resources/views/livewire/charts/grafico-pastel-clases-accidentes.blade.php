<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between grid grid-cols-1">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfico de Pastel - Clases de Accidente</h2>
        <p class="text-slate-600 text-xs dark:text-slate-400 mt-2">Este gráfico muestra qué tan comunes son diferentes clases de accidente.</p>

    </header>

    <div id="dashboard-pie-chart-legend-2" class="px-5 py-3">
        <!-- Icono de ojo -->
        <button id="toggleLegendBtn-pie2" class="text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
            <div class="grid grid-cols-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                        clip-rule="evenodd" />
                </svg>
                <x-label>Informacion</x-label>
            </div>
        </button>

        <ul class="flex flex-wrap text-xs" style="display: none; column-count: 3;"></ul>
    </div>

    <div id="additional-info-pie2" class="px-5" style="display: none; ">
        <!-- Información adicional -->
        <ul class="flex flex-col text-xs">
            <li><b>Clase con más accidentes:</b> {{ $labels[array_search(max($counts), $counts)] }} ({{ max($counts) }} accidentes)</li>
            <li><b>Clase con menos accidentes:</b> {{ $labels[array_search(min($counts), $counts)] }} ({{ min($counts) }} accidentes)</li>
            <li>La clase "{{ $labels[array_search(max($counts), $counts)] }}" tiene la mayor cantidad de accidentes, lo que indica que es la más común.</li>
            <li>La clase "{{ $labels[array_search(min($counts), $counts)] }}" tiene la menor cantidad de accidentes, lo que indica que es la menos común.</li>


        </ul>
    </div>
    <div class="grow mt-2">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-pie2" width="300" height="280"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById("chart-pie2").getContext("2d");

        const labels = {!! json_encode($labels) !!};
        const counts = {!! json_encode($counts) !!};

        // Generar colores aleatorios
        const randomColors = Array.from({ length: counts.length }, getRandomColor);

        const pieChart = new Chart(ctx, {
            type: "doughnut",
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
                    },
                },
                hoverOffset: 8, // Ajusta este valor según tus preferencias
            },
        });

        // Agregar leyendas al elemento legend
        const legend = document.getElementById('dashboard-pie-chart-legend-2');
        const legendList = legend.querySelector('ul');
        labels.forEach((label, index) => {
            const color = randomColors[index];
            const listItem = document.createElement('li');
            listItem.innerHTML =
                `<span style="display:inline-block;width:15px;height:15px;background-color:${color};margin-right:5px;"></span>${label}: ${counts[index]} &nbsp;&nbsp; `;
            listItem.style.marginBottom = '5px';
            legendList.appendChild(listItem);
        });

        // Función para cerrar la información adicional cuando se hace clic fuera de ella
        document.addEventListener('click', function (event) {
            const isClickInsideLegend = legend.contains(event.target);
            const isClickInsideInfo = document.getElementById('additional-info-pie2').contains(event.target);

            if (!isClickInsideLegend && !isClickInsideInfo) {
                legendList.style.display = 'none';
                document.getElementById('additional-info-pie2').style.display = 'none';
            }
        });

        // Función para generar un color aleatorio mejorada
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
        }

        // Manejar el clic en el botón de alternar leyenda e información adicional
        document.getElementById('toggleLegendBtn-pie2').addEventListener('click', function () {
            const legendDisplayStyle = legendList.style.display;
            const additionalInfoDisplayStyle = document.getElementById('additional-info-pie2').style.display;

            legendList.style.display = legendDisplayStyle === 'none' ? 'block' : 'none';
            document.getElementById('additional-info-pie2').style.display = additionalInfoDisplayStyle === 'none' ? 'block' : 'none';
        });
    });
</script>
