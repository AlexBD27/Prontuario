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
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Opciones de Reporte</h2>
    
                    <form id="export-form" method="GET">
                        @csrf
    
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte</label>
                            <div>
                                <input type="radio" id="all_reports" name="report_type" value="all" class="mr-2" checked>
                                <label for="all_reports" class="text-sm text-gray-700">Todos mis Números Generados (Periodo Actual)</label>
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
                                <input type="radio" id="custom_range" name="report_type" value="custom" class="mr-2">
                                <label for="custom_range" class="text-sm text-gray-700">Personalizado</label>
                            </div>
                        </div>

                        <div id="document_filters" class="space-y-6" style="display: none;">
                            <div>
                                <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Documento</label>
                                <select id="document_type" name="document_type" class="select2-documento shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="" selected>Selecciona un tipo de documento</option>
                                    <option value=0 selected>TODOS</option>
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
                                    <option value=0 selected>TODOS</option>
                                    @foreach($girotypes as $girotype)
                                        <option value="{{ $girotype->id }}">{{ $girotype->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div id="custom_filters" class="space-y-6 mt-4" style="display: none;">
                            <div>
                                <label for="period" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Año</label>
                                <select id="period" name="period" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="" selected>Selecciona un año</option>
                                    <option value=0 selected>TODOS</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Mes(es)</label>
                                <button type="button" id="toggle_all" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-3">
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
    
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('report') }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    onclick="setAction('{{ route('export.user', Auth::user()->worker->id) }}')"
                                    class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                Exportar a Excel
                            </button>
                            <button type="submit" 
                                    onclick="setAction('{{ route('report.user', Auth::user()->worker->id) }}')" 
                                    class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Generar PDF
                            </button>
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
                const allReportsRadio = document.getElementById('all_reports');
                const customRangeRadio = document.getElementById('custom_range');
                const derivationRadio = document.getElementById('derivation');
                const documentRadio = document.getElementById('doctype');
                const customFilters = document.getElementById('custom_filters');
                const derivationFilters = document.getElementById('derivation_filters');
                const documentFilters = document.getElementById('document_filters');
        
                    const toggleFilters = () => {
                        document.getElementById('document_type').value = '';
                        document.getElementById('derivation_type').value = '';
                        document.getElementById('period').value = '';

                    if(allReportsRadio.checked){
                        customFilters.style.display = 'none';
                        derivationFilters.style.display = 'none';
                        documentFilters.style.display = 'none';
                    }
                    else if(documentRadio.checked){
                        derivationFilters.style.display = 'none';
                        customFilters.style.display = 'none';
                        documentFilters.style.display = 'block';
                    }
                    else if (customRangeRadio.checked) {
                        documentFilters.style.display = 'block';
                        derivationFilters.style.display = 'block';
                        customFilters.style.display = 'block';
                    }
                    else if (derivationRadio.checked) {
                        derivationFilters.style.display = 'block';
                        customFilters.style.display = 'none';
                        documentFilters.style.display = 'none';
                    }
                };
        
                allReportsRadio.addEventListener('change', toggleFilters);
                customRangeRadio.addEventListener('change', toggleFilters);
                derivationRadio.addEventListener('change', toggleFilters);
                documentRadio.addEventListener('change', toggleFilters);
            });
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
