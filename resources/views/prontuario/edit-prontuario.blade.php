<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Número') }}
        </h2>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
                        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto px-4 py-8">
                <div class="max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Editar Número</h2>

                    <form id="formulario" action="{{ route('prontuario.update', $prontuario->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        
                        <h6 class="text-lg font-bold text-gray-600 mt-8 mb-4">Descripción de Documento</h6>
                        <div class="space-y-4">
                            <div class="mb-6 px-3">
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label> 
                                <select name="document_id" id="document" class="select2-documento shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                    <option value="" disabled selected>Seleccione un documento</option>
                                    @foreach($doc_types as $doc_type)
                                        <option value="{{ $doc_type->id }}" 
                                            {{ old('document_id', $prontuario->doc_type_id ?? '') == $doc_type->id ? 'selected' : '' }}>
                                            {{ $doc_type->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('document_id')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 px-3">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject', $prontuario->subject ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                @error('subject')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 px-3">
                                <label for="folios" class="block text-sm font-medium text-gray-700 mb-2">Folios</label>
                                <input type="number" name="folios" id="folios" value="{{ old('folios', $prontuario->folios ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                                @error('folios')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 px-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Giro</label>
                                <div class="mt-2">
                                    @foreach($giros as $giro)
                                        <div class="flex items-center mt-2">
                                            <input type="radio" id="tipo_giro_{{ $giro->slug }}" name="tipo_giro" value="{{ $giro->slug }}" 
                                                class="form-radio" 
                                                onchange="toggleGiroFields('{{ $giro->slug }}')" 
                                                {{ old('tipo_giro', $selectedGiroType ?? '') == $giro->slug ? 'checked' : '' }}>
                                            <label for="tipo_giro_{{ $giro->slug }}" class="ml-2">{{ ucfirst($giro->description) }}</label>
                                        </div>
                                    @endforeach
                                    @error('tipo_giro')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <h6 class="text-lg font-bold text-gray-600 mt-4 mb-4">Destino de Documento</h6>
                            <div id="camposExterno" class="hidden space-y-4 px-3">
                                <div>
                                    <label for="entidad_externa" class="block text-sm font-medium text-gray-700 mb-2">Entidad Externa</label>
                                    <select name="entidad_externa" id="entidad_externa" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                        <option value="" disabled>Seleccione una entidad</option>
                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}" 
                                                {{ old('entidad_externa', $selectedEntityId ?? '') == $entity->id ? 'selected' : '' }}>
                                                {{ $entity->description }}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div id="camposPublico" class="space-y-4 px-3">
                                <div>
                                    <label for="tipo_publico" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Público</label>
                                    <select name="tipo_publico" id="tipo_publico" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                        <option value="" disabled selected>Seleccione un tipo de público</option>
                                        @foreach($public_types as $publictype)
                                            <option value="{{ $publictype->id }}" 
                                                {{ old('tipo_publico', $selectedTipoPublicoId ?? '') == $publictype->id ? 'selected' : '' }}>
                                                {{ $publictype->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="camposInterno" class="hidden space-y-4 px-3">
                                <div>
                                    <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                                    <select id="area" name="area" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" onchange="cargarTiposGrupo()">
                                        <option value="">Seleccione un área</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" 
                                                {{ old('area', $selectedAreaId ?? '') == $area->id ? 'selected' : '' }}>
                                                {{ $area->description }}
                                            </option>
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

                            <h6 class="text-lg font-bold text-gray-600 mt-4 mb-4">Estado de Número</h6>

                            <div class="mb-6 px-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <div class="flex items-center space-x-4">
                                    <label for="approved" class="inline-flex items-center">
                                        <input type="radio" name="approved" id="approved" value="1" class="form-radio" 
                                            {{ $prontuario->approved == 1 ? 'checked' : '' }}>
                                        <span class="ml-2">Aprobado</span>
                                    </label>
                                    <label for="disapproved" class="inline-flex items-center">
                                        <input type="radio" name="approved" id="disapproved" value="0" class="form-radio" 
                                            {{ $prontuario->approved == 0 ? 'checked' : '' }}>
                                        <span class="ml-2">Desaprobado</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6 px-3">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                                <input type="text" name="comment" id="comment" value="{{ old('comment', $prontuario->comment ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                @error('comment')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>                        
                        
                        <div class="mt-10 flex items-center space-x-4">
                            <a href="{{ route('prontuario', $prontuario->giroType->slug) }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
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


    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        <script>
            document.getElementById('comment').addEventListener('input', function (event) {
                event.target.value = event.target.value.toUpperCase();
            });
            document.getElementById('subject').addEventListener('input', function (event) {
                event.target.value = event.target.value.toUpperCase();
            });
        </script>

        <script>
            const areasData = @json($areas);
            const userAreaId = @json($areaResponsibleWorker);
            const selectedAreaId = @json($selectedAreaId);
            const selectedTipoGrupoId = @json($selectedTipoGrupoId);
            const selectedGrupoId = @json($selectedGrupoId);
            const selectedSubgrupoId = @json($selectedSubgrupoId);
        
            document.addEventListener('DOMContentLoaded', () => {
                const selectedTipoGiro = @json($selectedGiroType);
                const selectedEntityId = @json($selectedEntityId);
                const selectedTipoPublicoId = @json($selectedTipoPublicoId);
                

                document.getElementById('formulario').addEventListener('submit', function () {
                    const areaField = document.getElementById('area');
                    if (areaField.hasAttribute('disabled')) {
                        areaField.removeAttribute('disabled');
                    }
                });


                if (selectedEntityId) {
                        document.getElementById('entidad_externa').value = selectedEntityId;
                    } else {
                        document.getElementById('entidad_externa').value = '';
                }

                if (selectedTipoPublicoId) {
                        document.getElementById('tipo_publico').value = selectedTipoPublicoId;
                    } else {
                        document.getElementById('tipo_publico').value = '';
                }

                if (selectedTipoGiro) {
                    const radioGiro = document.querySelector(`input[name="tipo_giro"][value="${selectedTipoGiro}"]`);
                    if (radioGiro) {
                        radioGiro.checked = true;
                    }
                    showFields(selectedTipoGiro);
                }
        
                if (selectedTipoGiro === 'internos' || selectedTipoGiro === 'entre-equipos' || selectedTipoGiro === 'personales') { 
                    if (selectedAreaId) {
                        document.getElementById('area').value = selectedAreaId;
                        if (selectedTipoGiro === 'entre-equipos') {
                            document.getElementById('area').setAttribute('disabled', 'true');
                        }
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
                }
                
            });
        
            function showFields(tipoGiro) {
                console.log("DENTRO DE SHOW: "+tipoGiro);
                document.getElementById('camposExterno').classList.toggle('hidden', tipoGiro !== 'externos');
                document.getElementById('camposInterno').classList.toggle('hidden', tipoGiro !== 'internos' && tipoGiro !== 'entre-equipos');
                document.getElementById('camposPublico').classList.toggle('hidden', tipoGiro !== 'publicos');
            }

            function toggleGiroFields(tipoGiro) {
                let areaField = document.getElementById('area');
                let grupoField = document.getElementById('grupo');
                let subgrupoField = document.getElementById('subgrupo');

                document.getElementById('tipo_grupo').value = '';
                document.getElementById('grupo').value = '';
                document.getElementById('subgrupo').value = '';
                document.getElementById('entidad_externa').value = '';
                document.getElementById('tipo_publico').value = '';

                document.getElementById('camposExterno').classList.toggle('hidden', tipoGiro !== 'externos');
                document.getElementById('camposInterno').classList.toggle('hidden', tipoGiro !== 'internos' && tipoGiro !== 'entre-equipos');
                document.getElementById('camposPublico').classList.toggle('hidden', tipoGiro !== 'publicos');

                if (tipoGiro === 'entre-equipos') {
                    if (userAreaId) {
                        areaField.value = userAreaId;
                    }
                    areaField.setAttribute('disabled', 'true');
                } 
                else if (tipoGiro === 'personales') {
                    areaField.value = selectedAreaId;
                    grupoField.value = selectedGrupoId;
                    subgrupoField.value = selectedSubgrupoId;
                } 
                else {
                    areaField.value = '';
                    areaField.removeAttribute('disabled');
                }
            }
        
            function cargarTiposGrupo(callback) {
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
                if (callback) callback();
            }
        
            function cargarGrupos(callback) {
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
                            if (areaTipoGrupo) {
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
                if (callback) callback();
            }
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