<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
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
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Crear Nuevo Usuario</h2> 
                    
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Datos Personales</h6>
                        <div class="mb-6 px-3">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                            <input name="name" id="name" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                            @error('name')
                                    <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-6 px-3">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI</label>
                            <input name="dni" id="dni" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                            @error('dni')
                                    <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div> 

                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Puesto</h6>
                        
                        <div id="camposInterno" class="space-y-4 mb-6 px-3">
                            <div>
                                <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                                <select id="area" name="area" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarTiposGrupo()">
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="tipoGrupoContainer" class="hidden">
                                <label for="tipo_grupo" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Grupo</label>
                                <select id="tipo_grupo" name="tipo_grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarGrupos()">
                                    <option value="">Seleccione un tipo de grupo</option>
                                </select>
                            </div>

                            <div id="grupoContainer" class="hidden">
                                <label for="grupo" class="block text-sm font-medium text-gray-700 mb-2">Grupo</label>
                                <select id="grupo" name="grupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarSubgrupos()">
                                    <option value="">Seleccione un grupo</option>
                                </select>
                            </div>

                            <div id="subgrupoContainer" class="hidden">
                                <label for="subgrupo" class="block text-sm font-medium text-gray-700 mb-2">Subgrupo</label>
                                <select id="subgrupo" name="subgrupo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                    <option value="">Seleccione un subgrupo</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6 px-3">
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                            <input name="position" id="position" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                            @error('position')
                                    <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Datos de Usuario</h6>

                        <div class="mb-6 px-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                            <input name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                            @error('email')
                                    <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6 px-3">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                            @error('password')
                                    <div style="color: red;">{{ $message }}</div>
                            @enderror
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