<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generar Reporte') }}
        </h2>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto px-4 py-8">
                <div class="max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Opciones de Reporte - Administrador</h2>
    
                    <form id="export-form" method="GET">
                        @csrf
    
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte</label>
                            <div>
                                <input type="radio" id="all_reports" name="report_type" value="all" class="mr-2" checked>
                                <label for="all_reports" class="text-sm text-gray-700">Todos los Números Generados</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="all_reports_actual_period" name="report_type" value="all_actual_period" class="mr-2">
                                <label for="all_reports_actual_period" class="text-sm text-gray-700">Todos los Números (Periodo Actual)</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="doctype" name="report_type" value="doctype" class="mr-2">
                                <label for="doctype" class="text-sm text-gray-700">Por tipo de Documento (Periodo Actual)</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="derivation" name="report_type" value="derivation" class="mr-2">
                                <label for="derivation" class="text-sm text-gray-700">Por tipo de Derivación (Periodo Actual)</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="lineal_cm" name="report_type" value="lineal_cm" class="mr-2">
                                <label for="lineal_cm" class="text-sm text-gray-700">Centrímetros Lineales</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="worker_reports" name="report_type" value="worker" class="mr-2">
                                <label for="worker_reports" class="text-sm text-gray-700">Por Trabajador</label>
                            </div>
                            <div class="mt-2">
                                <input type="radio" id="custom_range" name="report_type" value="custom" class="mr-2">
                                <label for="custom_range" class="text-sm text-gray-700">Personalizado</label>
                            </div>
                            
                        </div>

                        <div id="document_filters" class="space-y-6" style="display: none;">
                            <div>
                                <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Documento</label>
                                <select id="document_type" name="document_type" class="select2-documento shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="" selected>Selecciona un tipo de documento</option>
                                    <option value=0>TODOS</option>
                                    @foreach($doctypes as $doctype)
                                        <option value="{{ $doctype->id }}">{{ $doctype->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="derivation_filters" class="space-y-6 mt-4" style="display: none;">
                            <div>
                                <label for="derivation_type" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Derivación</label>
                                <select id="derivation_type" name="derivation_type" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="" selected>Selecciona una derivación</option>
                                    <option value=0>TODOS</option>
                                    @foreach($girotypes as $girotype)
                                        <option value="{{ $girotype->id }}">{{ $girotype->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="worker_filters" class="space-y-6 mt-4" style="display: none;">                            
                            <div id="camposInterno" class="space-y-4">
                                <div>
                                    <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Área</label>
                                    <select id="area" name="area" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarTiposGrupo()">
                                        <option value="">Seleccione un área</option>
                                        <option value=0>TODOS</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="tipoGrupoContainer" class="hidden">
                                    <label for="tipo_grupo" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Tipo de Grupo</label>
                                    <select id="tipo_grupo" name="tipo_grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarGrupos()">
                                    </select>
                                </div>

                                <div id="grupoContainer" class="hidden">
                                    <label for="grupo" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Grupo</label>
                                    <select id="grupo" name="grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarSubgrupos()">
                                    </select>
                                </div>

                                <div id="workerContainer" class="hidden">
                                    <label for="worker" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Trabajador</label>
                                    <select id="worker" name="worker" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="date_filters" class="space-y-6 mt-4" style="display: none;">
                            <div>
                                <label for="worker_period" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Año</label>
                                <select id="worker_period" name="worker_period" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="" selected>Selecciona un año</option>
                                    <option value=0>TODOS</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="worker_months" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Mes(es)</label>
                                <button type="button" id="worker_toggle_all" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-3">
                                    Seleccionar Todos
                                </button>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="checkbox" id="month_1" name="months[]" value="1" class="mr-2">
                                        <label for="month_1" class="text-sm text-gray-700">Enero</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_2" name="months[]" value="2" class="mr-2">
                                        <label for="month_2" class="text-sm text-gray-700">Febrero</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_3" name="months[]" value="3" class="mr-2">
                                        <label for="month_3" class="text-sm text-gray-700">Marzo</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_4" name="months[]" value="4" class="mr-2">
                                        <label for="month_4" class="text-sm text-gray-700">Abril</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_5" name="months[]" value="5" class="mr-2">
                                        <label for="month_5" class="text-sm text-gray-700">Mayo</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_6" name="months[]" value="6" class="mr-2">
                                        <label for="month_6" class="text-sm text-gray-700">Junio</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_7" name="months[]" value="7" class="mr-2">
                                        <label for="month_7" class="text-sm text-gray-700">Julio</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_8" name="months[]" value="8" class="mr-2">
                                        <label for="month_8" class="text-sm text-gray-700">Agosto</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_9" name="months[]" value="9" class="mr-2">
                                        <label for="month_9" class="text-sm text-gray-700">Septiembre</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_10" name="months[]" value="10" class="mr-2">
                                        <label for="month_10" class="text-sm text-gray-700">Octubre</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_11" name="months[]" value="11" class="mr-2">
                                        <label for="month_11" class="text-sm text-gray-700">Noviembre</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="month_12" name="months[]" value="12" class="mr-2">
                                        <label for="month_12" class="text-sm text-gray-700">Diciembre</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="lineal_filters" class="space-y-6 mt-4" style="display: none;">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input type="date" id="start_date" name="start_date" 
                                       value="{{ request('start_date') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                <input type="date" id="end_date" name="end_date" 
                                       value="{{ request('end_date') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>

                        <div id="buttons">
                            <div class="flex justify-end space-x-4 mt-6">
                                <a href="{{ route('report') }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                    onclick="setAction('{{ route('export.admin') }}')"
                                    class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    Exportar a Excel
                                </button>
                                <button type="submit" 
                                        onclick="setAction('{{ route('report.admin') }}')" 
                                        class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    Generar PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function setAction(url) {
                const form = document.getElementById('export-form');
                form.action = url;
            }
        </script>
        
        <script>
            document.addEventListener('DOMContentLoaded', () => {
            const reportTypeInputs = document.querySelectorAll('input[name="report_type"]');
            const documentFilters = document.getElementById('document_filters');
            const derivationFilters = document.getElementById('derivation_filters');
            const linealFilters = document.getElementById('lineal_filters');
            const workerFilters = document.getElementById('worker_filters');
            const dateFilters = document.getElementById('date_filters');
            const workerPeriod = document.getElementById('worker_period');
            const workerMonths = document.getElementById('worker_months');
            const toggleAllButton = document.getElementById('worker_toggle_all');


            const resetFilters = () => {
                workerFilters.style.display = 'none';
                documentFilters.style.display = 'none';
                derivationFilters.style.display = 'none';
                dateFilters.style.display = 'none';
                linealFilters.style.display = 'none';

                document.getElementById('tipoGrupoContainer').classList.add('hidden');
                document.getElementById('grupoContainer').classList.add('hidden');
                document.getElementById('workerContainer').classList.add('hidden');
                
                document.getElementById('document_type').value = '';
                document.getElementById('derivation_type').value = '';
                document.getElementById('area').value = '';
                document.getElementById('tipo_grupo').value = '';
                document.getElementById('grupo').value = '';
                document.getElementById('worker').value = '';
                document.getElementById('worker_period').value = '';
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';

            };

            reportTypeInputs.forEach(input => {
                input.addEventListener('change', () => {
                    resetFilters(); 
                    if (input.value === 'custom') {
                        documentFilters.style.display = 'block';
                        derivationFilters.style.display = 'block';
                        workerFilters.style.display = 'block';
                        dateFilters.style.display = 'block';
                    } else if (input.value === 'doctype') {
                        documentFilters.style.display = 'block';
                    } else if (input.value === 'derivation') {
                        derivationFilters.style.display = 'block';
                    } else if (input.value === 'worker') {
                        workerFilters.style.display = 'block';
                        dateFilters.style.display = 'block';
                    } else if (input.value === 'lineal_cm') {
                        linealFilters.style.display = 'block';
                    }
                });
            });

            workerPeriod.addEventListener('change', () => {
                workerMonths.style.display = workerPeriod.value === 'all_years' ? 'none' : 'block';
            });

            toggleAllButton.addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('#worker_months input[type="checkbox"]');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkboxes.forEach(cb => cb.checked = !allChecked);
            });
        });
        </script>

        <script>
            const areasData = @json($areas);

            function toggleGiroFields() {
                const reportType = document.querySelector('input[name="report_type"]:checked').value;
                document.getElementById('camposInterno').classList.toggle('hidden', reportType !== 'worker');
            }

            function cargarTiposGrupo() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoSelect = document.getElementById('tipo_grupo');
                tipoGrupoSelect.innerHTML = '<option value selected="">Seleccione un tipo de grupo</option>';
                tipoGrupoSelect.innerHTML += '<option value="">TODOS</option>';
                
                
                if (areaId) {
                    const area = areasData.find(a => a.id == areaId);
                    if (area && area.group_types) {
                        area.group_types.forEach(tipoGrupo => {
                            tipoGrupoSelect.innerHTML += `<option value="${tipoGrupo.id}">${tipoGrupo.description}</option>`;
                        });
                        document.getElementById('tipoGrupoContainer').classList.remove('hidden');
                    }
                } else {
                    document.getElementById('tipoGrupoContainer').classList.add('hidden');
                }
                document.getElementById('grupoContainer').classList.add('hidden');
                document.getElementById('workerContainer').classList.add('hidden');
            }

            function cargarGrupos() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoId = document.getElementById('tipo_grupo').value;
                const grupoSelect = document.getElementById('grupo');
                grupoSelect.innerHTML = '<option value selected="">Seleccione un grupo</option>';
                grupoSelect.innerHTML += '<option value="">TODOS</option>';
                

                if (areaId && tipoGrupoId) {
                    const area = areasData.find(a => a.id == areaId);
                    if (area) {
                        const tipoGrupo = area.group_types.find(tg => tg.id == tipoGrupoId);
                        if (tipoGrupo) {
                            const areaTipoGrupo = tipoGrupo.area_group_types.find(agt => agt.area_id == areaId);
                            if(areaTipoGrupo){
                                areaTipoGrupo.groups.forEach(grupo => {
                                    grupoSelect.innerHTML += `<option value="${grupo.id}">${grupo.description}</option>`;
                                });
                                document.getElementById('grupoContainer').classList.remove('hidden');
                            }
                            
                        }
                    }
                } else {
                    document.getElementById('grupoContainer').classList.add('hidden');
                }
                document.getElementById('workerContainer').classList.add('hidden');
            }

            function cargarSubgrupos() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoId = document.getElementById('tipo_grupo').value;
                const grupoId = document.getElementById('grupo').value;
                const subgrupoSelect = document.getElementById('worker');
                subgrupoSelect.innerHTML = '<option value selected="">Seleccione un trabajador</option>';
                subgrupoSelect.innerHTML += '<option value="">TODOS</option>';
                
                if (areaId && tipoGrupoId && grupoId) {
                    const area = areasData.find(a => a.id == areaId);
                    if (area) {
                        const tipoGrupo = area.group_types.find(tg => tg.id == tipoGrupoId);
                        if (tipoGrupo) {
                            const areaTipoGrupo = tipoGrupo.area_group_types.find(agt => agt.area_id == areaId);
                            if(areaTipoGrupo){
                                const grupo = areaTipoGrupo.groups.find(gr => gr.id == grupoId)
                                if(grupo){
                                    grupo.workers.forEach(worker =>{
                                        subgrupoSelect.innerHTML += `<option value="${worker.id}">${worker.name}</option>`;
                                    });
                                    document.getElementById('workerContainer').classList.remove('hidden');
                                }
                            }
                        }
                    }
                } else {
                    document.getElementById('workerContainer').classList.add('hidden');
                }
            }
        </script>
        
        <script>
            document.getElementById('toggle_all').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('input[name="months[]"]');
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        
                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
        
                this.textContent = allChecked ? 'Seleccionar Todos' : 'Deseleccionar Todos';
            });
        </script>

        <script>
            $(document).ready(function () {
                $('.select2-documento').select2({
                    placeholder: 'Seleccione una opción',
                    allowClear: true,
                    width: '100%'
                });

                $('.select2-container--default .select2-selection--single').addClass('px-3 py-2 border border-gray-300 rounded-md text-sm flex items-center');

                $('.select2-container--default .select2-selection--single').css({
                    'height': '42px',
                    'line-height': '1.5rem',
                    'font-size': '0.95rem',
                    'color': '#000',
                    'display': 'flex',
                    'align-items': 'center'
                });

                $('.select2-container--default .select2-selection__rendered').css({
                    'color': '#000',
                    'padding-left': '0px'
                });

                $('.select2-container--default .select2-selection--single .select2-selection__arrow').css({
                    'top': '50%',
                    'transform': 'translateY(-50%)'
                });
            });
        </script>    
    @endpush
</x-app-layout>
