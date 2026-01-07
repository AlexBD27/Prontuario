<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Número') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Generar Nuevo Número de Documento</h2>
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

                    <form id="tramiteForm" action="{{ route('prontuario.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div class="mb-6">
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                                <select name="document_id" id="document" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                    <option value="" disabled selected>Seleccione un documento</option>
                                    @foreach($doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}">{{ $doc_type->description }}</option>
                                    @endforeach
                                </select>
                                @error('document_id')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="folios" class="block text-sm font-medium text-gray-700 mb-2">Folios</label>
                                <input type="number" name="folios" id="folios" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                @error('folios')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Giro</label>
                                <div class="mt-2">
                                    @foreach($giros as $giro)
                                        <div class="flex items-center mt-2">
                                            <input type="radio" id="tipo_giro_{{ $giro->id }}" name="tipo_giro" value="{{ $giro->id }}" class="form-radio" onchange="toggleGiroFields()"
                                            {{ $giro->id == 1 ? 'checked' : '' }}>
                                            <label for="tipo_giro_{{ $giro->id }}" class="ml-2">{{ ucfirst($giro->description) }}</label>
                                        </div>
                                    @endforeach
                                    @error('tipo_giro')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div id="camposExterno" class="hidden space-y-4">
                                <div>
                                    <label for="entidad_externa" class="block text-sm font-medium text-gray-700 mb-2">Entidad Externa</label>
                                    <select name="entidad_externa" id="entidad_externa" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                        <option value="" disabled selected>Seleccione una entidad</option>
                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}">{{ $entity->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="camposInterno" class="hidden space-y-4">
                                <div>
                                    <label for="area" class="block text-gray-700 text-sm font-bold mb-2">Área</label>
                                    <select id="area" name="area" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="cargarTiposGrupo()">
                                        <option value="">Seleccione un área</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="tipoGrupoContainer" class="hidden">
                                    <label for="tipo_grupo" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Grupo</label>
                                    <select id="tipo_grupo" name="tipo_grupo" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="cargarGrupos()">
                                        <option value="">Seleccione un tipo de grupo</option>
                                    </select>
                                </div>

                                <div id="grupoContainer" class="hidden">
                                    <label for="grupo" class="block text-gray-700 text-sm font-bold mb-2">Grupo</label>
                                    <select id="grupo" name="grupo" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="cargarSubgrupos()">
                                        <option value="">Seleccione un grupo</option>
                                    </select>
                                </div>

                                <div id="subgrupoContainer" class="hidden">
                                    <label for="subgrupo" class="block text-gray-700 text-sm font-bold mb-2">Subgrupo</label>
                                    <select id="subgrupo" name="subgrupo" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">Seleccione un subgrupo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center space-x-4">
                            <a href="{{ Auth::user()->role === 'Admin' ? route('prontuario') : route('dashboard.user') }}"
                                class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out mr-4">
                                 Cancelar
                             </a>
                            <button id="generateNumberBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Generar Número
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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

        document.addEventListener('DOMContentLoaded', function () {
            toggleGiroFields();
        });
    </script>
</x-app-layout>