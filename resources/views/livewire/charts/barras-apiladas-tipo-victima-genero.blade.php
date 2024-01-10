<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Barras Apiladas por Tipo de Víctima y Género</h2>
        <p class="text-slate-600 text-xs dark:text-slate-400 mt-2">La gráfica de Barras Apiladas por Tipo de Víctima y Género tiene como objetivo representar visualmente la distribución de accidentes en función del tipo de víctima y género,
            permitiendo identificar patrones y comparar las proporciones de accidentes entre diferentes categorías.</p>

    </header>

    <!-- Botón de ojo para ocultar/mostrar información -->
    <button id="toggleInfoButton" class="px-3 py-2 mt-2 mb-4 text-xs bg-slate-200 text-gray-700 dark:bg-slate-800 dark:text-gray-300 ">
        <i class="far fa-eye"></i> Mostrar Información
    </button>

    <!-- Información importante inicialmente oculta -->
    <div id="importantInfo" class="px-5 py-4 text-xs" style="display: none;">
        <div class="mb-4">
            <strong>Tipo de Víctima con más mujeres:</strong> {{ $tipoVictimaMasMujeres }} ({{ $accidentesTipoVictimaMasMujeres }} accidentes)
        </div>
        <div class="mb-4">
            <strong>Tipo de Víctima con menos mujeres:</strong> {{ $tipoVictimaMenosMujeres }} ({{ $accidentesTipoVictimaMenosMujeres }} accidentes)
        </div>
        <div class="mb-4">
            <strong>Tipo de Víctima con más hombres:</strong> {{ $tipoVictimaMasHombres }} ({{ $accidentesTipoVictimaMasHombres }} accidentes)
        </div>
        <div class="mb-4">
            <strong>Tipo de Víctima con menos hombres:</strong> {{ $tipoVictimaMenosHombres }} ({{ $accidentesTipoVictimaMenosHombres }} accidentes)
        </div>
    </div>

    <div class="grow" style="max-width: 100%; overflow: hidden; margin: auto;">
        <div style="overflow-x: auto; padding-right: 15px; padding-left: 15px;">
            <canvas id="chart-barras-apiladas-tipo-victima-genero" width="1000" height="300"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            const ctx = document.getElementById('chart-barras-apiladas-tipo-victima-genero').getContext('2d');
            const data = @json($data);

            const tiposVictima = [...new Set(data.map(item => item.tipo_victima))];
            const generos = [...new Set(data.map(item => item.genero))];

            const datasets = generos.map(genero => {
                const counts = tiposVictima.map(tipo =>
                    data.find(item => item.tipo_victima === tipo && item.genero === genero)?.total ?? 0
                );

                return {
                    label: genero,
                    data: counts,
                    backgroundColor: getRandomColor(),
                };
            });

            const barrasApiladasConfig = {
                type: 'bar',
                data: {
                    labels: tiposVictima,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'Tipo de Victima',
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Cantidad de Accidentes',
                            },

                            stacked: true,
                            beginAtZero: true,
                        },
                    },
                    animation: {
                        duration: 1000,
                    },
                },
            };

            const chart = new Chart(ctx, barrasApiladasConfig);

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Agregar evento clic al botón de ojo
            const toggleInfoButton = document.getElementById('toggleInfoButton');
            const importantInfo = document.getElementById('importantInfo');

            toggleInfoButton.addEventListener('click', function () {
                // Alternar la visibilidad de la información importante
                const isInfoVisible = importantInfo.style.display !== 'none';
                importantInfo.style.display = isInfoVisible ? 'none' : 'block';

                // Actualizar el texto del botón
                toggleInfoButton.innerHTML = isInfoVisible ? '<i class="far fa-eye"></i> Mostrar Información' : '<i class="far fa-eye-slash"></i> Ocultar Información';
            });

            // Agregar evento clic al documento para ocultar la información al hacer clic en otro lugar
            document.addEventListener('click', function (event) {
                if (event.target !== toggleInfoButton && event.target.closest('#importantInfo') === null) {
                    importantInfo.style.display = 'none';
                    // Restaurar el texto del botón
                    toggleInfoButton.innerHTML = '<i class="far fa-eye"></i> Mostrar Información';
                }
            });
        });
    </script>
</div>
