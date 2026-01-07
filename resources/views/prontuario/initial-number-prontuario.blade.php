<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Establecer Números Iniciales') }}
        </h2>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Seleccione Tipo de Giro</h2>

                    <form id="numeroInicialForm" action="{{ route('prontuario.initial.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Giro</label>
                                <div class="flex space-x-4">
                                    @foreach ($giroTypes as $giro)
                                        <label>
                                            <input type="radio" name="tipo_giro" value="{{ $giro->id }}" data-slug="{{ $giro->slug }}" class="tipo-giro">
                                            {{ $giro->description }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div id="camposInterno" class="hidden space-y-4">
                                <label for="area_interno" class="block text-sm font-medium text-gray-700">Área</label>
                                <select name="area_interno" id="area_interno" class="w-full px-3 py-2 border rounded-md">
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->description }}</option>
                                    @endforeach
                                </select>
                                
                                <label for="intern_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                <select name="intern_document" id="intern_document" class="select2-documento w-full">
                                    <option value="">Seleccione un documento</option>
                                    @foreach($intern_doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="camposExterno" class="hidden space-y-4">
                                <label for="extern_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                <select name="extern_document" id="extern_document" class="select2-documento w-full">
                                    <option value="">Seleccione un documento</option>
                                    @foreach($extern_doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="camposPublico" class="hidden space-y-4">
                                <label for="area_publico" class="block text-sm font-medium text-gray-700">Área</label>
                                <select name="area_publico" id="area_publico" class="w-full px-3 py-2 border rounded-md">
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->description }}</option>
                                    @endforeach
                                </select>
                                
                                <label for="public_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                <select name="public_document" id="public_document" class="select2-documento w-full">
                                    <option value="">Seleccione un documento</option>
                                    @foreach($public_doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="camposGrupos" class="hidden space-y-4">
                                <label for="grupo" class="block text-sm font-medium text-gray-700">Buscar Grupo</label>
                                <select name="grupo" id="grupo" class="select2-documento w-full">
                                    <option value="">Seleccione un grupo</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->description }}</option>
                                    @endforeach
                                </select>
                                
                                <label for="groups_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                <select name="groups_document" id="groups_document" class="select2-documento w-full">
                                    <option value="">Seleccione un documento</option>
                                    @foreach($group_doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="camposTrabajador" class="hidden space-y-4">
                                <label for="trabajador" class="block text-sm font-medium text-gray-700">Trabajador</label>
                                <select name="worker_id" id="trabajador" class="select2-documento w-full">
                                    <option value="">Seleccione un trabajador</option>
                                    @foreach($workers as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                    @endforeach
                                </select>

                                <label for="personal_document" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                                <select name="personal_document" id="personal_document" class="select2-documento w-full">
                                    <option value="">Seleccione un documento</option>
                                    @foreach($personal_doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-4 mb-6">
                                <label for="numero_inicial" class="block text-sm font-medium text-gray-700">Número Inicial</label>
                                <input type="number" name="numero_inicial" id="numero_inicial"
                                    class="w-full px-3 py-2 border rounded-md" required
                                    value="{{ old('numero_inicial') }}">
                            </div>
                        </div>
                        
                        <div class="mt-6 flex items-center space-x-4">
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.querySelectorAll('.tipo-giro').forEach(radio => {
                radio.addEventListener('change', function () {
                    document.getElementById('camposInterno').classList.add('hidden');
                    document.getElementById('camposExterno').classList.add('hidden');
                    document.getElementById('camposPublico').classList.add('hidden');
                    document.getElementById('camposGrupos').classList.add('hidden');
                    document.getElementById('camposTrabajador').classList.add('hidden');

                    limpiarCampos();

                    const slug = this.dataset.slug;

                    switch (slug) {
                        case 'internos':
                            document.getElementById('camposInterno').classList.remove('hidden');
                            break;
                        case 'externos':
                            document.getElementById('camposExterno').classList.remove('hidden');
                            break;
                        case 'publicos':
                            document.getElementById('camposPublico').classList.remove('hidden');
                            break;
                        case 'entre-equipos':
                            document.getElementById('camposGrupos').classList.remove('hidden');
                            break;
                        case 'personales':
                            document.getElementById('camposTrabajador').classList.remove('hidden');
                            break;
                    }

                });
            });


            function limpiarCampos() {
                document.querySelectorAll('#camposInterno select, #camposInterno input, \
                                        #camposExterno select, #camposExterno input, \
                                        #camposPublico select, #camposPublico input, \
                                        #camposGrupos select, #camposGrupos input, \
                                        #camposTrabajador select, #camposTrabajador input')
                .forEach(element => {
                    element.value = '';
                });

                document.getElementById('numero_inicial').value = '';
            }

            document.getElementById('buscadorTrabajador').addEventListener('input', function () {
                let filtro = this.value.toLowerCase();
                let opciones = document.querySelectorAll('#trabajador option');

                opciones.forEach(opcion => {
                    if (opcion.value === "") return; 
                    let texto = opcion.textContent.toLowerCase();
                    opcion.style.display = texto.includes(filtro) ? 'block' : 'none';
                });
            });

            document.getElementById('buscadorGrupo').addEventListener('input', function () {
                let filtro = this.value.toLowerCase();
                let opciones = document.querySelectorAll('#grupo option');

                opciones.forEach(opcion => {
                    if (opcion.value === "") return; 
                    let texto = opcion.textContent.toLowerCase();
                    opcion.style.display = texto.includes(filtro) ? 'block' : 'none';
                });
            });
        </script>

        <script>
            const initialNumbers = @json($initialNumbers);

            function obtenerNumeroInicial() {
                const radioSeleccionado = document.querySelector('input[name="tipo_giro"]:checked');
                if (!radioSeleccionado) return;

                const tipoGiroId = radioSeleccionado.value;
                const tipoGiroSlug = radioSeleccionado.dataset.slug;

                let tipoDocumento = '';

                switch (tipoGiroSlug) {
                    case 'internos':
                        tipoDocumento = document.getElementById('intern_document')?.value;
                        break;
                    case 'externos':
                        tipoDocumento = document.getElementById('extern_document')?.value;
                        break;
                    case 'publicos':
                        tipoDocumento = document.getElementById('public_document')?.value;
                        break;
                    case 'entre-equipos':
                        tipoDocumento = document.getElementById('groups_document')?.value;
                        break;
                    case 'personales':
                        tipoDocumento = document.getElementById('personal_document')?.value;
                        break;
                    default:
                        tipoDocumento = '';
                }

                let area = document.getElementById('area_interno')?.value || document.getElementById('area_publico')?.value || '';
                let grupo = document.getElementById('grupo')?.value || '';
                let trabajador = document.getElementById('trabajador')?.value || '';

                let key = `${tipoGiroId}_${tipoDocumento}_${area}_${grupo}_${trabajador}`;

                if (initialNumbers[key]) {
                    document.getElementById('numero_inicial').value = initialNumbers[key].initial_number;
                } else {
                    document.getElementById('numero_inicial').value = '';
                }
            }

            document.querySelectorAll('.tipo-giro, select').forEach(element => {
                element.addEventListener('change', obtenerNumeroInicial);
            });

            document.addEventListener("DOMContentLoaded", obtenerNumeroInicial);
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
