<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tipos de Público') }}
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-6">
                <a href="{{ route('publictype.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Tipo de Público
                </a>
            </div>              
            

            <div class="overflow-x-auto bg-white rounded-lg shadow w-full p-6">
                <table id="publictype-table" class="min-w-full leading-normal w-full">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Abreviación
                            </th>
                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Descripción
                            </th>
                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Activo
                            </th>
                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="grouptypes-body">
                        @foreach($publicTypes as $publictype)
                        <tr class="odd:bg-gray-50 even:bg-white">
                            <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                {{ $publictype->id }}
                            </td>
                            <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                {{ $publictype->abbreviation }}
                            </td>
                            <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                {{ Str::limit($publictype->description, 50) }}
                            </td>
                            <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                <span class="relative inline-block px-3 py-1 font-semibold {{ $publictype->active ? 'text-green-900' : 'text-red-900' }} leading-tight">
                                    <span aria-hidden class="absolute inset-0 {{ $publictype->active ? 'bg-green-200' : 'bg-red-200' }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $publictype->active ? 'Activo' : 'Inactivo' }}</span>
                                </span>
                            </td>
                            <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('publictype.edit', $publictype->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('publictype.destroy', $publictype->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta Entidad?');">
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

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
                const table = $('#publictype-table').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    }
                });

                const searchContainer = $('#publictype-table_filter');
                const lengthContainer = $('#publictype-table_length');

                searchContainer.addClass('flex justify-end items-center mt-4 mb-2');
                searchContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                searchContainer.find('input').addClass('block w-48 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');

                lengthContainer.addClass('flex justify-start items-center mt-4 mb-2');
                lengthContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                lengthContainer.find('select').addClass('block w-24 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');

                $('.dataTables_wrapper').addClass('p-4');
            });
        </script>

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
    @endpush

</x-app-layout>