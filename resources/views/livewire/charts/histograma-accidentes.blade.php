<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-sm">Histograma de Edades</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Este histograma muestra la distribución de accidentes según las edades de las personas involucradas.</p>

    </header>
    <div id="histograma-edades-legend" class="px-5 py-3">
        <button id="toggleHistogramaEdadesLegendBtn"
            class="text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
            <div class="grid grid-cols-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd"
                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                        clip-rule="evenodd" />
                </svg>
                <x-label>Informacion</x-label>
            </div>
        </button>

        <div id="informacionEdades" class="px-5 py-3" style="display: none;">
            <p class="font-semibold text-slate-800 dark:text-slate-100 text-xs">
                Edades con más accidentes:
                <span id="edadesMasAccidentes" style="margin-right: 5px;"></span>
                <span id="accidentesMasAccidentes" style="margin-right: 5px;"></span>
                <div class="color-box" id="colorBoxMasAccidentes"></div>
            </p>
            <p class="font-semibold text-slate-800 dark:text-slate-100 text-xs">
                Edades con menos accidentes:
                <span id="edadesMenosAccidentes" style="margin-right: 5px;"></span>
                <span id="accidentesMenosAccidentes" style="margin-right: 5px;"></span>
                <div class="color-box" id="colorBoxMenosAccidentes"></div>
            </p>
        </div>

        <div id="histogramaEdadesLegendList" class="flex flex-wrap" style="display: none; column-count: 4; font-size: 10px;"></div>
    </div>
    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="histograma-edades" width="595" height="300"></canvas>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('livewire:load', function () {
    const darkMode = localStorage.getItem('dark-mode') === 'true';
    const textColor = {
            light: '#A0A0A080',
            dark: '#64748B'
        };





    const ctx = document.getElementById('histograma-edades').getContext('2d');
    const edades = @json($edades);

    // Función para generar colores aleatorios
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Obtener edades únicas presentes en la gráfica
    const edadesUnicas = Array.from(new Set(edades));

    // Configuración del histograma
    const histogramaConfig = {
        type: 'bar',
        data: {
            labels: edadesUnicas,
            datasets: [{
                label: 'Cantidad de Accidentes',
                data: edadesUnicas.map(edad => edades.filter(e => e === edad).length),
                backgroundColor: Array.from({ length: edadesUnicas.length }, () => getRandomColor()),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                tension: 0.9,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,




            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false, // Ocultar por defecto
                    position: 'bottom',
                    labels: {
                        boxWidth: 15,
                        generateLabels: function (chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function (label, i) {
                                    const dataset = data.datasets[0];
                                    const value = dataset.data[i];
                                    const color = dataset.backgroundColor[i];
                                    return {
                                        text: `${label}: ${value} accidentes`,
                                        fillStyle: color,
                                        strokeStyle: color,
                                        lineWidth: 2,
                                        hidden: isNaN(value) || value === 0,
                                        textColor: color,
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: darkMode ? textColor.dark : textColor.light,
                        },

                    type: 'linear',
                    position: 'bottom',
                    title: {
                            display: true,
                            text: 'Edad',
                        },

                },
                y: {
                    grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: darkMode ? textColor.dark : textColor.light,
                        },
                    beginAtZero: true,
                    title: {
                            display: true,
                            text: 'Accidentes',
                        },
                }
            }
        }
    };

    const histogramaChart = new Chart(ctx, histogramaConfig);

    const histogramaEdadesLegendList = document.getElementById('histogramaEdadesLegendList');
    const toggleHistogramaEdadesLegendBtn = document.getElementById('toggleHistogramaEdadesLegendBtn');
    const informacionEdades = document.getElementById('informacionEdades');

    // Función para alternar la visibilidad de la leyenda e información
    toggleHistogramaEdadesLegendBtn.addEventListener('click', function () {
        const legendDisplayStyle = histogramaEdadesLegendList.style.display;
        histogramaEdadesLegendList.style.display = legendDisplayStyle === 'none' ? 'block' : 'none';
        informacionEdades.style.display = legendDisplayStyle === 'none' ? 'block' : 'none';
    });

    // Función para cerrar la información adicional cuando se hace clic fuera de ella
    document.addEventListener('click', function (event) {
        const isClickInside = informacionEdades.contains(event.target) || toggleHistogramaEdadesLegendBtn.contains(event.target);
        if (!isClickInside) {
            histogramaEdadesLegendList.style.display = 'none';
            informacionEdades.style.display = 'none';
        }
    });

    // Inicializar la leyenda
    const legendItems = histogramaChart.legend.legendItems;
    legendItems.forEach(item => {
        const legendItem = document.createElement('div');
        legendItem.className = 'legend-item';
        legendItem.style.display = 'flex';
        legendItem.style.alignItems = 'center';
        legendItem.style.marginRight = '10px';

        const colorBox = document.createElement('div');
        colorBox.className = 'color-box';
        colorBox.style.backgroundColor = item.fillStyle;
        colorBox.style.width = '10px';
        colorBox.style.height = '10px';
        colorBox.style.marginRight = '5px';

        legendItem.appendChild(colorBox);

        const label = document.createElement('span');
        label.textContent = item.text;
        label.style.fontSize = '10px';

        legendItem.appendChild(label);

        histogramaEdadesLegendList.appendChild(legendItem);
    });

    histogramaEdadesLegendList.style.display = 'none';

    // Obtener la edad con más accidentes
    const maxAccidentes = Math.max(...histogramaConfig.data.datasets[0].data);
    const edadesMasAccidentesIndexes = getAllIndexes(histogramaConfig.data.datasets[0].data, maxAccidentes);
    const edadesMasAccidentes = edadesMasAccidentesIndexes.map(index => histogramaConfig.data.labels[index]);
    document.getElementById('edadesMasAccidentes').textContent = edadesMasAccidentes.join(', ');
    document.getElementById('accidentesMasAccidentes').textContent = `(${maxAccidentes} accidentes)`;
    document.getElementById('colorBoxMasAccidentes').style.backgroundColor = histogramaConfig.data.datasets[0].backgroundColor[edadesMasAccidentesIndexes[0]];

    // Obtener la edad con menos accidentes
    const minAccidentes = Math.min(...histogramaConfig.data.datasets[0].data);
    const edadesMenosAccidentesIndexes = getAllIndexes(histogramaConfig.data.datasets[0].data, minAccidentes);
    const edadesMenosAccidentes = edadesMenosAccidentesIndexes.map(index => histogramaConfig.data.labels[index]);
    document.getElementById('edadesMenosAccidentes').textContent = edadesMenosAccidentes.join(', ');
    document.getElementById('accidentesMenosAccidentes').textContent = `(${minAccidentes} accidentes)`;
    document.getElementById('colorBoxMenosAccidentes').style.backgroundColor = histogramaConfig.data.datasets[0].backgroundColor[edadesMenosAccidentesIndexes[0]];






});

// Función para obtener todos los índices de un valor en un array
function getAllIndexes(arr, val) {
    const indexes = [];
    for (let i = 0; i < arr.length; i++) {
        if (arr[i] === val) {
            indexes.push(i);
        }
    }
    return indexes;
}
</script>
