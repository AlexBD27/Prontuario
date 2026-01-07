<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Número Interno') }}
        </h2>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Generar Nuevo Número Interno</h2>
                    @if ($errors->has('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '{{ $errors->first('error') }}',
                                });
                            });
                        </script>
                    @endif

                    <form id="tramiteForm" action="{{ route('prontuario.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Descripción de Documento</h6>
                        <div class="space-y-4">
                            <div class="mb-6 px-3">
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                                <select name="document_id" id="document" class="select2-documento shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                    <option value="" disabled selected>Seleccione un documento</option>
                                    @foreach($doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                                @error('document_id')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 px-3">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                                <input type="text" name="subject" id="subject" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                @error('subject')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 px-3">
                                <label for="folios" class="block text-sm font-medium text-gray-700 mb-2">Folios</label>
                                <input type="number" name="folios" id="folios" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                @error('folios')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="tipo_giro" value={{$slug}}>

                            <h6 class="text-lg font-bold text-gray-600 mt-4 mb-4">Destino de Documento</h6>

                            <div id="camposInterno" class="space-y-4 px-3">
                                <div>
                                    <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                                    <select id="area" name="area" class="select2-documento w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarTiposGrupo()">
                                        <option value="">Seleccione un área</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="tipoGrupoContainer" class="hidden">
                                    <label for="tipo_grupo" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Grupo</label>
                                    <select id="tipo_grupo" name="tipo_grupo" class="select2-documento w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarGrupos()">
                                        <option value="">Seleccione un tipo de grupo</option>
                                    </select>
                                </div>

                                <div id="grupoContainer" class="hidden">
                                    <label for="grupo" class="block text-sm font-medium text-gray-700 mb-2">Grupo</label>
                                    <select id="grupo" name="grupo" class="select2-documento w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarSubgrupos()">
                                        <option value="">Seleccione un grupo</option>
                                    </select>
                                </div>

                                <div id="subgrupoContainer" class="hidden">
                                    <label for="subgrupo" class="block text-sm font-medium text-gray-700 mb-2">Subgrupo</label>
                                    <select id="subgrupo" name="subgrupo" class="select2-documento w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                        <option value="">Seleccione un subgrupo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 flex items-center space-x-4">
                            <a href="{{ Auth::user()->role === 'ADMIN' ? route('prontuario', $slug) : route('prontuario.show', [$slug, Auth::user()->worker->id]) }}"
                                class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out mr-4">
                                 Cancelar
                            </a>
                            <button id="generateNumberBtn" class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Generar Número
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('generateNumberBtn').addEventListener('click', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro de querer generar el número?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, generar',
                    cancelButtonText: 'No, cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('tramiteForm').submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Nos vemos para la próxima',
                            icon: 'info',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            });
        </script>


        <script>
            const areasData = @json($areas);

            function toggleGiroFields() {
                document.getElementById('area').value = '';
                document.getElementById('tipo_grupo').value = '';
                document.getElementById('grupo').value = '';
                document.getElementById('subgrupo').value = '';
                document.getElementById('entidad_externa').value = '';

                const tipoGiro = parseInt(document.querySelector('input[name="tipo_giro"]:checked').value, 10);
                document.getElementById('camposExterno').classList.toggle('hidden', tipoGiro !== 2);
                document.getElementById('camposInterno').classList.toggle('hidden', tipoGiro !== 1);
            }

            function cargarTiposGrupo() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoSelect = document.getElementById('tipo_grupo');
                tipoGrupoSelect.innerHTML = '<option value="">Seleccione un tipo de grupo</option>';
                
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
                document.getElementById('subgrupoContainer').classList.add('hidden');
            }

            function cargarGrupos() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoId = document.getElementById('tipo_grupo').value;
                const grupoSelect = document.getElementById('grupo');
                grupoSelect.innerHTML = '<option value="">Seleccione un grupo</option>';
                
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
                document.getElementById('subgrupoContainer').classList.add('hidden');
            }

            function cargarSubgrupos() {
                const areaId = document.getElementById('area').value;
                const tipoGrupoId = document.getElementById('tipo_grupo').value;
                const grupoId = document.getElementById('grupo').value;
                const subgrupoSelect = document.getElementById('subgrupo');
                subgrupoSelect.innerHTML = '<option value="">Seleccione un subgrupo</option>';
                
                if (areaId && tipoGrupoId && grupoId) {
                    const area = areasData.find(a => a.id == areaId);
                    if (area) {
                        const tipoGrupo = area.group_types.find(tg => tg.id == tipoGrupoId);
                        if (tipoGrupo) {
                            const areaTipoGrupo = tipoGrupo.area_group_types.find(agt => agt.area_id == areaId);
                            if(areaTipoGrupo){
                                const grupo = areaTipoGrupo.groups.find(gr => gr.id == grupoId)
                                if(grupo){
                                    grupo.sub_groups.forEach(subgrupo =>{
                                        subgrupoSelect.innerHTML += `<option value="${subgrupo.id}">${subgrupo.description}</option>`;
                                    });
                                    document.getElementById('subgrupoContainer').classList.remove('hidden');
                                }
                            }
                        }
                    }
                } else {
                    document.getElementById('subgrupoContainer').classList.add('hidden');
                }
            }
        </script>

        <script>
            document.getElementById('subject').addEventListener('input', function (event) {
                event.target.value = event.target.value.toUpperCase();
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