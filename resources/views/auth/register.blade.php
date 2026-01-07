<x-guest-layout>

    
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Lastname -->
            <div class="mt-4">
                <x-input-label for="lastname" :value="__('Apellido')" />
                <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>

            <!-- dni -->
            <div class="mt-4">
                <x-input-label for="dni" :value="__('DNI')" />
                <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required autofocus autocomplete="dni" />
                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
            </div>

            <div id="camposInterno" class="space-y-4">
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

            <!-- position -->
            <div class="mt-4">
                <x-input-label for="position" :value="__('Cargo')" />
                <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" required autofocus autocomplete="position" />
                <x-input-error :messages="$errors->get('position')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>


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

</x-guest-layout>
