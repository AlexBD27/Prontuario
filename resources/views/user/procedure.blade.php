<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Números Generados') }}
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-6">
                <a href="{{ route('prontuario.create.bytype', $giroType->slug)}}"
                    
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Generar Número
                </a>
            </div>
            <div x-data="modalComponent">
                <div class="overflow-x-auto bg-white rounded-lg shadow w-full p-6">
                    <table id="prontuario-table" class="min-w-full leading-normal w-full">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    N°
                                </th>
                                @if ($giroType->slug === 'internos' || $giroType->slug === 'entre-equipos' || $giroType->slug === 'personales')
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

                                @if ($giroType->slug === 'externos')
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        E. Externa
                                    </th>
                                @endif
                                
                                @if ($giroType->slug === 'publicos')
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        T. Público
                                    </th>
                                @endif
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
                                @if ($giroType->slug === 'externos')
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        Firma
                                    </th>
                                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                        Archivo Adjunto
                                    </th>
                                @endif
                                <th class="px-3 py-3 border-b-2 border-gray-200 bg-blue-900 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody id="prontuarios-body">
                            @foreach($prontuarios as $prontuario)
                            <tr class="odd:bg-gray-50 even:bg-white">
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $loop->iteration }}
                                </td>
                                @if ($giroType->slug === 'internos' || $giroType->slug === 'entre-equipos' || $giroType->slug === 'personales')
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->area->abbreviation ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->group->description ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->subGroup->description ?? '-' }}
                                    </td>
                                @endif

                                @if ($giroType->slug === 'externos')
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->entity->description ?? '-' }}
                                    </td>
                                @endif
                                
                                @if ($giroType->slug === 'publicos')
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        {{ $prontuario->publicType->description ?? '-' }}
                                    </td>
                                @endif
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
                                @if ($giroType->slug === 'externos')
                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        @if($prontuario->attachment?->is_signed)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </td>

                                    <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                        @if($prontuario->attachment)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 00-5.656-5.656L5.636 10.93a6 6 0 108.485 8.485l4.95-4.95" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 7H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v10a2 2 0 01-2 2z" />
                                                <line x1="4" y1="20" x2="20" y2="4" stroke="red" stroke-width="2" />
                                            </svg>
                                        @endif
                                    </td>
                                @endif
                                
                                <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex items-center space-x-2">
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

                                        <a href="{{ route('prontuario.showOne', [$giroType->slug, $prontuario->id]) }}"
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
                    }
                });

                const searchContainer = $('#prontuario-table_filter');
                const lengthContainer = $('#prontuario-table_length');

                searchContainer.addClass('flex justify-end items-center mt-4 mb-2');
                searchContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                searchContainer.find('input').addClass('block w-48 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');

                lengthContainer.addClass('flex justify-start items-center mt-4 mb-2');
                lengthContainer.find('label').addClass('flex items-center space-x-2 text-sm text-gray-700');
                lengthContainer.find('select').addClass('block w-24 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500');

                $('.dataTables_wrapper').addClass('p-4');
            });
        </script>

        <script>
            @if(session('created'))
                Swal.fire({
                    title: `
                        {{ session('created')['message'] }}
                        <span style="font-size: 1.5em; font-weight: bold;">{{ session('created')['number'] }}</span>
                    `,
                    html: `
                        @if(session('created'))
                            Destino: <br>
                            @if(session('created')['area'])
                                {{ session('created')['area'] }}
                                @if(session('created')['group_type']) - {{ session('created')['group_type'] }} @endif
                                @if(session('created')['group']) - {{ session('created')['group'] }} @endif
                                @if(session('created')['subgroup']) - {{ session('created')['subgroup'] }} @endif
                            @elseif(session('created')['entity'])
                                {{ session('created')['entity'] }}
                            @elseif(session('created')['publictype'])
                                {{ session('created')['publictype'] }}
                            @endif
                            <br>

                            Documento: {{ session('created')['document'] }}<br>
                            Fecha: {{ \Carbon\Carbon::parse(session('created')['date'])->format('d/m/Y') }}
                        @endif
                    `,
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                });
            @endif
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
    @endpush
</x-app-layout>