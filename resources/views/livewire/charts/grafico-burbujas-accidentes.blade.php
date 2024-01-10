<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfico de Burbujas</h2>
    </header>
    <div id="dashboard-bubble-chart-legend" class="px-5 py-3">
        <ul class="flex flex-wrap"></ul>
    </div>
    <div class="grow">
        <div style="max-width: 100%; overflow: hidden; margin: auto;">
            <canvas id="chart-bubbles" width="595" height="400"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById("chart-bubbles").getContext("2d");
        const data = {!! json_encode($data) !!};

        // Organizar los datos por tipo de lesión
        const groupedData = groupBy(data, 'lesion');

        // Configuración del gráfico de burbujas
        const bubbleChartConfig = {
            type: 'bubble',
            data: {
                datasets: Object.keys(groupedData).map((lesion, index) => ({
                    label: lesion,
                    data: groupedData[lesion].map(item => ({
                        x: item.edad,
                        y: index + 1, // Esto se usa para apilar las burbujas de diferentes tipos de lesiones
                        r: item.total * 5, // El tamaño de la burbuja está proporcional al total de accidentes
                    })),
                    backgroundColor: getRandomColor(),
                    borderColor: 'rgba(255,255,255,0.7)',
                })),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Edad',
                        },
                        min: 0,
                        max: 100,
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Tipo de Lesión',
                        },
                        ticks: {
                            stepSize: 1,
                            callback: (value, index) => Object.keys(groupedData)[index],
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                },
            },
        };

        new Chart(ctx, bubbleChartConfig);

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
    });
</script>
