<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="container mx-auto px-4 py-8">
                <div class="max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Editar Usuario</h2>                   
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Datos Personales</h6>
                        <div class="mb-6 px-3">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                            <input name="name" id="name" value="{{$user->worker->name}}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                        </div>
                        <div class="mb-6 px-3">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI</label>
                            <input name="dni" id="dni" value="{{$user->worker->dni}}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                        </div> 
                        
                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Puesto</h6>

                        <div id="camposInterno" class="space-y-4 mb-6 px-3">
                            <div>
                                <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                                <select id="area" name="area" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarTiposGrupo()">
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ $area->id == old('area', $user->worker->group->area->id ?? '') ? 'selected' : '' }}>
                                            {{ $area->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div id="tipoGrupoContainer">
                                <label for="tipo_grupo" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Grupo</label>
                                <select id="tipo_grupo" name="tipo_grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarGrupos()">
                                    <option value="">Seleccione un tipo de grupo</option>
                                </select>
                            </div>
                        
                            <div id="grupoContainer">
                                <label for="grupo" class="block text-sm font-medium text-gray-700 mb-2">Grupo</label>
                                <select id="grupo" name="grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarSubgrupos()">
                                    <option value="">Seleccione un grupo</option>
                                </select>
                            </div>
                        
                            <div id="subgrupoContainer">
                                <label for="subgrupo" class="block text-sm font-medium text-gray-700 mb-2">Subgrupo</label>
                                <select id="subgrupo" name="subgrupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="">Seleccione un subgrupo</option>
                                </select>
                            </div>
                        </div>                       

                        <div class="mb-6 px-3">
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                            <input name="position" id="position" value="{{$user->worker->position}}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                        </div>

                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Datos de Usuario</h6>

                        <div class="mb-6 px-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                            <input type="text" name="email" id="email" value="{{$user->email}}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                        </div>

                        <div class="mb-6 px-3">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user') }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                        
        </div>
    </div>   

    <script>
        const areasData = @json($areas);
    
        document.addEventListener('DOMContentLoaded', () => {
            const selectedAreaId = @json($selectedAreaId);
            const selectedTipoGrupoId = @json($selectedTipoGrupoId);
            const selectedGrupoId = @json($selectedGrupoId);
            const selectedSubgrupoId = @json($selectedSubgrupoId);
    
            if (selectedAreaId) {
                document.getElementById('area').value = selectedAreaId;
                cargarTiposGrupo(() => {
                    if (selectedTipoGrupoId) {
                        document.getElementById('tipo_grupo').value = selectedTipoGrupoId;
                        cargarGrupos(() => {
                            if (selectedGrupoId) {
                                document.getElementById('grupo').value = selectedGrupoId;
                                cargarSubgrupos(() => {
                                    if (selectedSubgrupoId) {
                                        document.getElementById('subgrupo').value = selectedSubgrupoId;
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    
        function cargarTiposGrupo(callback) {
            const areaId = document.getElementById('area').value;
            const tipoGrupoSelect = document.getElementById('tipo_grupo');
            tipoGrupoSelect.innerHTML = '<option value="">Seleccione un tipo de grupo</option>';
    
            if (areaId) {
                const area = areasData.find(a => a.id == areaId);
                if (area?.group_types) {
                    area.group_types.forEach(tipoGrupo => {
                        tipoGrupoSelect.innerHTML += `<option value="${tipoGrupo.id}">${tipoGrupo.description}</option>`;
                    });
                }
            }
            document.getElementById('grupo').innerHTML = '<option value="">Seleccione un grupo</option>';
            document.getElementById('subgrupo').innerHTML = '<option value="">Seleccione un subgrupo</option>';
    
            if (callback) callback();
        }
    
        function cargarGrupos(callback) {
            const areaId = document.getElementById('area').value;
            const tipoGrupoId = document.getElementById('tipo_grupo').value;
            const grupoSelect = document.getElementById('grupo');
            grupoSelect.innerHTML = '<option value="">Seleccione un grupo</option>';
    
            if (areaId && tipoGrupoId) {
                const area = areasData.find(a => a.id == areaId);
                const tipoGrupo = area?.group_types.find(tg => tg.id == tipoGrupoId);
    
                if (tipoGrupo?.area_group_types) {
                    tipoGrupo.area_group_types.forEach(agt => {
                        if (agt.area_id == areaId) {
                            agt.groups.forEach(grupo => {
                                grupoSelect.innerHTML += `<option value="${grupo.id}">${grupo.description}</option>`;
                            });
                        }
                    });
                }
            }
            document.getElementById('subgrupo').innerHTML = '<option value="">Seleccione un subgrupo</option>';
    
            if (callback) callback();
        }
    
        function cargarSubgrupos(callback) {
            const areaId = document.getElementById('area').value;
            const tipoGrupoId = document.getElementById('tipo_grupo').value;
            const grupoId = document.getElementById('grupo').value;
            const subgrupoSelect = document.getElementById('subgrupo');
            subgrupoSelect.innerHTML = '<option value="">Seleccione un subgrupo</option>';
    
            if (areaId && tipoGrupoId && grupoId) {
                const area = areasData.find(a => a.id == areaId);
                const tipoGrupo = area?.group_types.find(tg => tg.id == tipoGrupoId);
                const areaTipoGrupo = tipoGrupo?.area_group_types.find(agt => agt.area_id == areaId);
                const grupo = areaTipoGrupo?.groups.find(g => g.id == grupoId);
    
                if (grupo?.sub_groups) {
                    grupo.sub_groups.forEach(subgrupo => {
                        subgrupoSelect.innerHTML += `<option value="${subgrupo.id}">${subgrupo.description}</option>`;
                    });
                }
            }
    
            if (callback) callback();
        }
    </script>    

    <script>
         document.getElementById('email').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
        document.getElementById('name').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
        document.getElementById('position').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
        document.getElementById('password').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
    </script>

</x-app-layout>