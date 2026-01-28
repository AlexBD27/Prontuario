<x-app-layout>

    @php
        $showAreaGroup = in_array($selectedOption, ['internos', 'entre-equipos', 'personales']);
        $showEntidad = $selectedOption === 'externos';
        $showPublico = $selectedOption === 'publicos';
    @endphp


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($selectedOption == 'internos')
                {{ __('Números Internos') }}
            @elseif($selectedOption == 'externos')
                {{ __('Números Externos') }}
            @elseif($selectedOption == 'publicos')
                {{ __('Números Públicos') }}
            @elseif($selectedOption == 'entre-equipos')
                {{ __('Números Entre Equipos') }}
            @elseif($selectedOption == 'personales')
                {{ __('Números Personales') }}
            @else
                {{ __('Números Generados') }}
            @endif
        </h2>        
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!--
            <div class="flex justify-end mb-6">
                <a href="{{ route('prontuario.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Añadir Registro
                </a>
            </div>

        -->
            <div x-data="modalComponent">
                <div class="overflow-x-auto bg-white rounded-lg shadow w-full p-6">
                    <table id="prontuario-table" class="min-w-full leading-normal w-full">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    N°
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Responsable
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Giro
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Documento
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Número
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Folios
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Asunto
                                </th>
                                @if($showAreaGroup)
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        Area
                                    </th>
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        Grupo
                                    </th>
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        Subgrupo
                                    </th>
                                @endif
                                @if($showEntidad)
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        E. Externa
                                    </th>
                                @endif
                                @if($showPublico)
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        T. Público
                                    </th>
                                @endif
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Comentario
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody id="prontuarios-body" x-data>
                            @foreach($prontuarios as $prontuario)
                            <tr class="odd:bg-gray-50 even:bg-white">
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    <a href="#" class="text-blue-500 hover:underline btn-view-worker" data-worker-id="{{ $prontuario->worker->id }}">
                                        {{ $prontuario->worker->name }}
                                    </a>
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->giroType->description }}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->docType->description }}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->number}}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->folios}}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ \Carbon\Carbon::parse($prontuario->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->subject }}
                                </td>
                                @if($showAreaGroup)
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->area->abbreviation ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->group->description ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->subgroup->description ?? '-' }}
                                    </td>
                                @endif
                                @if($showEntidad)
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->entity->description ?? '-' }}
                                    </td>
                                @endif
                                @if($showPublico)
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->publicType->description ?? '-' }}
                                    </td>
                                @endif
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $prontuario->comment ?? '-'}}
                                </td>
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold {{ $prontuario->approved ? 'text-green-900' : 'text-red-900' }} leading-tight">
                                        <span aria-hidden class="absolute inset-0 {{ $prontuario->approved ? 'bg-green-200' : 'bg-red-200' }} opacity-50 rounded-full"></span>
                                        <span class="relative">{{ $prontuario->approved ? 'Aprobado' : 'Desaprobado' }}</span>
                                    </span>
                                </td>

                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex items-center space-x-2">

                                        
                                        <a href="{{ route('prontuario.edit', $prontuario->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>

                                        <form id="delete-form-{{ $prontuario->id }}" action="{{ route('prontuario.destroy', $prontuario->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="comment">
                                        </form>

                                        <button 
                                            type="button"
                                            onclick="rejectProntuario({{ $prontuario->id }})"
                                            class="text-red-600 hover:text-red-900 {{ $prontuario->approved === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $prontuario->approved === 0 ? 'disabled' : '' }}>
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>  
                                        
                                        <a href="{{ route('prontuario.showOne', [$selectedOption, $prontuario->id]) }}"
                                            class="text-gray-600 hover:text-gray-800"
                                            title="Ver detalle del número">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5 5-5
                                                        5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                const table = $('#prontuario-table').DataTable({
                    responsive: true,
                    fixedColumns: {
                        left: 1,
                        right: 1
                    },
                    ordering: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                });
                
                const searchContainer = $('#prontuario-table_filter');
                searchContainer.addClass('flex justify-end items-center space-x-4');
                searchContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                searchContainer.find('input').addClass('block w-48 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');
        
                const lengthContainer = $('#prontuario-table_length');
                lengthContainer.addClass('flex items-center space-x-4');
                lengthContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                lengthContainer.find('select').addClass('block w-24 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');
        
                $('.dataTables_wrapper').addClass('p-4');
            });
        </script>
        
        <script>
            document.querySelectorAll('.btn-view-worker').forEach(button => {
                button.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const workerId = this.dataset.workerId;
                    const worker = @json($prontuarios).find(p => p.worker.id == workerId)?.worker;

                    if (worker) {
                        Swal.fire({
                            title: 'Información del Trabajador',
                            html: `
                                <p><strong>Nombre:</strong> ${worker.name}</p>
                                <p><strong>Posición:</strong> ${worker.position || 'No especificado'}</p>
                                <p><strong>Area:</strong> ${worker.group?.area?.description || 'No especificado'} </p>
                                <p><strong>Grupo:</strong> ${worker.group?.description || 'No especificado'} </p>
                                <p><strong>Subgrupo:</strong> ${worker.sub_group?.description || 'No especificado'} </p>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo cargar la información del trabajador.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                        });
                    }
                });
            });
        </script>

        <script>
            function rejectProntuario(prontuarioId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Ingresa el motivo antes de desaprobar el número.',
                    input: 'text',
                    inputPlaceholder: 'Motivo',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, desaprobar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value.trim()) {
                            return 'Debes ingresar un motivo';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.getElementById(`delete-form-${prontuarioId}`);
                        let commentInput = form.querySelector('input[name="comment"]');
                        commentInput.value = result.value.toUpperCase(); 
                        form.submit();
                    }
                });
            }
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