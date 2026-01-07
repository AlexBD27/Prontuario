<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Áreas') }}
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


            <div class="flex justify-end mb-6">
                <a href="{{ route('area.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Área
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($areas as $area)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{$area->description}}</h2>
                            <p class="text-gray-600 mb-4">{{ $area->abbreviation}}</p>
                            <p class="text-sm text-gray-500 mb-4">Activa: {{ $area->active ? 'Sí' : 'No' }}</p>
                        </div>
                        <div class="bg-gray-50 px-6 py-4">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('area.groups', $area->id)}}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Detalle
                                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                <div class="flex space-x-6 mt-2 sm:mt-0">
                                    <a href="{{ route('area.edit', $area->id)}}" class="text-blue-600 hover:text-blue-800 flex items-center mr-2">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('area.destroy', $area->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('¿Estás seguro de que quieres eliminar esta área?')">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
