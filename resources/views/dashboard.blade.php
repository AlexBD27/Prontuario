<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->role === 'ADMIN')
                {{ __('DASHBOARD') }}
            @endif
            @if(auth()->user()->role === 'USER')
            {{ __('DASHBOARD - ') . auth()->user()->worker->group->area->description }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @if(auth()->user()->role === 'ADMIN')
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-600">
                            Historial de Números
                        </h3>
                        <p class="text-4xl font-extrabold text-red-500">{{ $totalProntuarios }}</p>
                    </div>
                @endif

                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números Internos</h3>
                    <p class="text-4xl font-extrabold text-blue-500">{{ $totalInternos }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números Externos</h3>
                    <p class="text-4xl font-extrabold text-blue-500">{{ $totalExternos }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números Públicos</h3>
                    <p class="text-4xl font-extrabold text-blue-500">{{ $totalPublicos }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números Entre Equipos</h3>
                    <p class="text-4xl font-extrabold text-blue-500">{{ $totalEquipos }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números Personales</h3>
                    <p class="text-4xl font-extrabold text-blue-500">{{ $totalPersonal }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600">Números en el Periodo Actual</h3>
                    <p class="text-4xl font-extrabold text-red-500">{{ $totalPeriodo }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6" style="height: 800px;">
                    <h3 class="text-lg font-bold text-gray-600">
                        @if(auth()->user()->role === 'ADMIN')
                            Números generados por Área
                        @else
                            Números generados por Grupo
                        @endif
                    </h3>
                    <canvas id="prontuariosPorArea"></canvas>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6" style="height: 800px;">
                    <h3 class="text-lg font-bold text-gray-600 mb-4">Números Generados por Tipo de Documento</h3><br>
                    <canvas id="prontuariosPorTipoDocumento"></canvas>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-600 mb-4">Trámites por Mes</h3>
                <canvas id="tramitesPorMes"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Cerrar'
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Cerrar'
                });
            </script>
        @endif

        <script>
            const prontuariosPorArea = @json($prontuariosPorArea);
            const prontuariosPorTipoDocumento = @json($prontuariosPorTipoDocumento);
            const tramitesPorMes = @json($tramitesPorMes);
            const predefinedColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#8B572A'];

            const areaColors = predefinedColors.slice(0, Math.min(prontuariosPorArea.length, 6));
            const ctxArea = document.getElementById('prontuariosPorArea').getContext('2d');
            new Chart(ctxArea, {
                type: 'bar',
                data: {
                    labels: prontuariosPorArea.map(item => item.area_abbreviation),
                    datasets: [{
                        label: 'Prontuarios',
                        data: prontuariosPorArea.map(item => item.total),
                        backgroundColor: areaColors,
                        borderColor: areaColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 20,  
                            bottom: 100,  
                            left: 10, 
                            right: 10  
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 20,
                                font: {
                                    size: 14
                                },
                                padding: 20,
                                usePointStyle: false,
                                boxHeight: 10,
                                generateLabels: function(chart) {
                                    const labels = chart.data.labels.map((label, index) => {
                                        return {
                                            text: `${prontuariosPorArea[index].area_description}`,
                                            fillStyle: chart.data.datasets[0].backgroundColor[index]
                                        };
                                    });
                                    return labels;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1 
                            }
                        }
                    }
                }
            });


            const chartColors = predefinedColors.slice(0, prontuariosPorTipoDocumento.length);
            const ctxTipoDocumento = document.getElementById('prontuariosPorTipoDocumento').getContext('2d');
            new Chart(ctxTipoDocumento, {
                type: 'doughnut',
                data: {
                    labels: prontuariosPorTipoDocumento.map(item => item.doc_type_name),
                    datasets: [{
                        data: prontuariosPorTipoDocumento.map(item => item.total),
                        backgroundColor: chartColors,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    layout: {
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0, 
                            left: 0
                        },
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20, 
                                boxWidth: 20,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const description = prontuariosPorTipoDocumento[context.dataIndex].doc_type_description;
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${description}: ${value}`;
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            color: '#fff',
                            font: {
                                size: 14,
                                weight: 'bold',
                            },
                            formatter: (value, context) => {
                                const total = context.chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${percentage}%`;
                            },
                            backgroundColor: '#000',
                            borderRadius: 5,
                            padding: 5,
                            borderWidth: 2,
                            borderColor: '#fff', 
                            offset: -10,
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            const monthNames = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            const ctxMes = document.getElementById('tramitesPorMes').getContext('2d');
            new Chart(ctxMes, {
                type: 'line',
                data: {
                    labels: tramitesPorMes.map(item => monthNames[item.month - 1]),
                    datasets: [{
                        label: 'Trámites',
                        data: tramitesPorMes.map(item => item.total),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });

        </script>
    @endpush
</x-app-layout>
