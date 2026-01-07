<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión del Área: ') . $area->description }}
        </h2>
    </x-slot>

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


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-6">Gestión de Grupos y Subgrupos</h3>

                <div class="mt-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-4">Añadir Tipo de Grupo Existente</h4>
                    <form action="{{ route('grouptype.assign') }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <input type="hidden" name="area_id" value="{{ $area->id }}">
                        <select name="group_type_id" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-purple-300" required>
                            <option value="" disabled selected>Seleccionar</option>
                            @foreach ($availableGroupTypes as $groupType)
                                <option value="{{ $groupType->id }}">{{ $groupType->description }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-purple-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-purple-600 transition">
                            Añadir Tipo de Grupo
                        </button>
                    </form>
                </div>

                <ul class="space-y-8 mt-8">
                    @foreach ($area->groupTypes as $groupType)
                        <li>
                            <div class="bg-blue-50 border-l-4 border-blue-800 p-4 rounded">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-xl font-bold text-blue-800">
                                        <i class="fas fa-layer-group"></i> {{ $groupType->description }}
                                    </h4>
                                    
                                    <form action="{{ route('grouptype.unassign') }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este tipo de grupo?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="area_id" value="{{ $area->id }}">
                                        <input type="hidden" name="group_type_id" value="{{ $groupType->id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-2 px-3 py-1 text-sm rounded bg-red-50 hover:bg-red-100 transition">
                                            <i class="fas fa-trash-alt"></i> Eliminar Tipo de Grupo
                                        </button>
                                    </form>
                                </div>
                                
                                <ul class="space-y-6 pl-6 mt-6">
                                    @foreach ($groupType->groups as $group)
                                        <li class="bg-gray-50 border rounded-lg shadow-sm p-4">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-lg font-medium text-gray-800 flex items-center gap-2">
                                                        <i class="fas fa-folder"></i> {{ $group->description }}
                                                    </p>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('group.edit', $group->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 px-3 py-1 text-sm rounded bg-blue-50 hover:bg-blue-100 transition">
                                                        <i class="fas fa-edit"></i> Editar Grupo
                                                    </a>

                                                    <form action="{{ route('group.destroy', $group->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este grupo?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-2 px-3 py-1 text-sm rounded bg-red-50 hover:bg-red-100 transition">
                                                            <i class="fas fa-trash-alt"></i> Eliminar Grupo
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>

                                            <ul class="mt-4 space-y-2 pl-8">
                                                @foreach ($group->subgroups as $subgroup)
                                                    <li class="flex justify-between items-center py-2 border-b">
                                                        <span class="text-gray-700 text-sm flex items-center gap-2">
                                                            <i class="fas fa-tag"></i> {{ $subgroup->description }}
                                                        </span>
                                                        <div class="flex justify-end gap-2">
                                                            <a href="{{ route('subgroup.edit', $subgroup->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 px-3 py-1 text-sm rounded bg-blue-50 hover:bg-blue-100 transition">
                                                                <i class="fas fa-edit"></i> Editar Subgrupo
                                                            </a>

                                                            <form action="{{ route('subgroup.destroy', $subgroup->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este subgrupo?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-2 px-3 py-1 text-sm rounded bg-red-50 hover:bg-red-100 transition">
                                                                    <i class="fas fa-trash-alt"></i> Eliminar Subgrupo
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <form action="{{ route('subgroup.store') }}" method="POST" class="mt-4 flex items-center">
                                                @csrf
                                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                <input type="text" id="subgroup_name" name="subgroup_name" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-green-300" placeholder="Nuevo Subgrupo" required>
                                                <input type="text" id="subgroup_abbreviation" name="subgroup_abbreviation" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-green-300" placeholder="Abreviatura" required>
                                                <button type="submit" class="ml-2 bg-green-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-green-600 transition">
                                                    Añadir Subgrupo
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>

                                <form action="{{ route('group.store') }}" method="POST" class="mt-6 flex items-center">
                                    @csrf
                                    <input type="hidden" name="area_id" value="{{ $area->id }}">
                                    <input type="hidden" name="group_type_id" value="{{ $groupType->id }}">
                                    <input type="text" id="group_name" name="group_name" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300" placeholder="Nuevo Grupo" required>
                                    <input type="text" id="abbreviation" name="abbreviation" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300" placeholder="Abreviatura" required>
                                
                                    <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-600 transition">
                                        Añadir Grupo
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('#abbreviation, #group_name, #subgroup_name, #subgroup_abbreviation').forEach(input => {
            input.addEventListener('input', function (event) {
                event.target.value = event.target.value.toUpperCase();
            });
        });
    </script>    
</x-app-layout>
