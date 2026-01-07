<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grupos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-6">
                <a href="{{ route('group.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Grupo
                </a>
            </div>


            <div class="mb-4">
                <form action="{{ route('group') }}" method="GET" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-grow">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar por descripción</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Descripción" onkeyup="searchSubAreas()" autocomplete="off">
                    </div>
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <select name="area" id="area" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Todas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->description }}" {{ request('area') == $area->description ? 'selected' : '' }}>{{ $area->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="is_active" id="is_active" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Todos</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
            



            <div class="overflow-x-auto bg-white rounded-lg shadow w-full">
                <table class="min-w-full leading-normal w-full">
                    <thead>
                        <tr>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Abreviación
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Área
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tipo de Grupo
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Activo
                            </th>
                            <th class="px-5 py-6 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="grupos-body">
                        @foreach($groups as $grupo)
                        <tr>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                {{ $grupo->id }}
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                {{ $grupo->abbreviation }}
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                {{ Str::limit($grupo->description, 50) }}
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                {{ $grupo->area->description}}
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                {{ $grupo->groupType->description}}
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold {{ $grupo->active ? 'text-green-900' : 'text-red-900' }} leading-tight">
                                    <span aria-hidden class="absolute inset-0 {{ $grupo->active ? 'bg-green-200' : 'bg-red-200' }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $grupo->active ? 'Activo' : 'Inactivo' }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-6 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('group.edit', $grupo->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('group.destroy', $grupo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta Sub Área?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
        </div>
    </div>



    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#grupos-body tr');
    
            rows.forEach(row => {
                const abbreviation = row.cells[1].textContent.toLowerCase();
                const description = row.cells[2].textContent.toLowerCase();
                const area = row.cells[4].textContent.toLowerCase();
    
                if (abbreviation.includes(searchTerm) || description.includes(searchTerm) || area.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</x-app-layout>