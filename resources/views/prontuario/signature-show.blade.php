<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Firmar Documento
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session('success') }}', confirmButtonText: 'Cerrar' });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({ icon: 'error', title: '¡Error!', text: '{{ session('error') }}', confirmButtonText: 'Cerrar' });
        </script>
    @endif

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Botón Volver --}}
            <div class="text-right mt-6">
                <a href="{{ route('firma.' . $from) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-sm text-gray-800 border border-gray-300 rounded hover:bg-gray-200 transition">
                    <svg class="h-4 w-4 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-.293l-6-6a1 1 0 010-1.414l6-6A1 1 0 0111.414 5.707L6.828 10l4.586 4.586A1 1 0 0110 18z" clip-rule="evenodd"/>
                    </svg>
                    Volver al listado
                </a>
            </div>


            <div class="bg-indigo-50 border-l-4 border-indigo-600 rounded-md p-6 shadow-sm">
                <p class="text-sm uppercase tracking-wide text-indigo-700 font-semibold">
                    Número generado
                </p>

                <p class="mt-1 text-3xl sm:text-4xl font-extrabold text-indigo-800">
                    {{ $prontuario->number }}
                </p>
            </div>


            {{-- Info Documento --}}
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <svg class="h-6 w-6 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12h6v1H9v-1zM9 14h6v1H9v-1zM6 12h1v1H6v-1zM6 14h1v1H6v-1zM9 10h6v1H9v-1zM6 10h1v1H6v-1z"/>
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h2v-1H4a1 1 0 01-1-1V6h14v8h-4v1h4a2 2 0 002-2V5a2 2 0 00-2-2H4z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700">Información del Documento</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800">
                    <div><strong>Tipo de Documento:</strong> {{ $prontuario->docType->description }}</div>
                    <div><strong>Asunto:</strong> {{ $prontuario->subject }}</div>
                    <div><strong>Folios:</strong> {{ $prontuario->folios }}</div>
                    <div><strong>Fecha de Registro:</strong> {{ $prontuario->created_at->format('d/m/Y H:i') }}</div>
                    <div><strong>Tipo de Giro:</strong> <span class="uppercase text-indigo-600 font-medium">{{ $slug }}</span></div>
                    <div>
                        <strong>Área de Origen:</strong>
                        {{ $prontuario->worker?->group?->area?->abbreviation }}
                        - {{ $prontuario->worker?->group?->description }}
                    </div>


                    <div><strong>Generado por:</strong> {{ $prontuario->worker->name }}</div>
                </div>
            </div>

            {{-- Bloque de documentos --}}
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100 space-y-6">

                <div class="flex items-center mb-4">
                    <svg class="h-6 w-6 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 012-2h4a1 1 0 01.707.293l5 5A1 1 0 0116 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V3zm8 0v4h4L12 3z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700">Archivo Adjunto</h3>
                </div>


                {{-- Documento original --}}
                <div>
                    {{-- <h3 class="text-lg font-bold text-gray-700 mb-3">Documento Original</h3> --}}
                    @if($prontuario->attachment)
                        <div class="bg-gray-50 border border-gray-300 rounded-md px-4 py-2 flex items-center justify-between">
                            <!-- <a href="{{ asset('storage/' . $prontuario->attachment->file_path) }}" target="_blank"
                                class="text-sm text-indigo-600 hover:text-indigo-800 truncate max-w-[80%]">
                                Documento original
                            </a> -->

                            <button
                                type="button"
                                onclick="openPdfViewer('{{ asset('storage/' . $prontuario->attachment->file_path) }}')"
                                class="text-sm text-indigo-600 hover:text-indigo-800 truncate max-w-[80%] text-left">
                                Documento original
                            </button>

                            <a href="{{ asset('storage/' . $prontuario->attachment->file_path) }}" download
                                class="text-indigo-600 hover:text-indigo-800" title="Descargar documento original">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <p class="text-red-600 text-sm">No hay documento original disponible.</p>
                    @endif
                </div>

                {{-- Documento firmado --}}
                <div>

                    @if($prontuario->attachment && $prontuario->attachment->signed_file_path)
                        <div class="bg-green-50 border border-green-300 rounded-md px-4 py-2 flex items-center justify-between mb-4">
                            <!-- <a href="{{ asset('storage/' . $prontuario->attachment->signed_file_path) }}" 
                            target="_blank"
                            class="text-sm text-green-700 hover:text-green-900 truncate max-w-[80%]">
                                Documento firmado
                            </a> -->

                            <button
                                type="button"
                                onclick="openPdfViewer('{{ asset('storage/' . $prontuario->attachment->signed_file_path) }}')"
                                class="text-sm text-green-700 hover:text-green-900 truncate max-w-[80%] text-left">
                                Documento firmado
                            </button>

                            <div class="flex items-center gap-3">

                                {{-- Eliminar --}}
                                <form action="{{ route('firma.delete', $prontuario->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('¿Seguro que deseas eliminar el documento firmado?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Eliminar documento firmado">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7m5 0V4h4v3" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Descargar --}}
                                <a href="{{ asset('storage/' . $prontuario->attachment->signed_file_path) }}" 
                                download
                                class="text-green-700 hover:text-green-900" 
                                title="Descargar documento firmado">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke-width="1.5" 
                                        stroke="currentColor" 
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 10.5l4.5 4.5 4.5-4.5M12 15V3" />
                                    </svg>
                                </a>

                                
                            </div>
                        </div>
                    @else
                        {{-- Formulario para subir documento firmado --}}
                        <form action="{{ route('firma.store', $prontuario->id) }}" 
                            method="POST" 
                            enctype="multipart/form-data" 
                            class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="file-upload" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subir Documento Firmado (PDF)
                                </label>

                                <div class="flex items-center gap-4">
                                    <label for="file-upload"
                                        class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md text-sm hover:bg-gray-200 transition">
                                        Seleccionar archivo
                                    </label>
                                    <span id="file-name" class="text-sm text-gray-600 truncate">Ningún archivo seleccionado</span>
                                </div>

                                <input type="file" name="file" id="file-upload" accept="application/pdf" class="hidden" required>
                                @error('file')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <button type="submit"
                                    class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-md transition duration-300 ease-in-out flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    Subir Documento Firmado
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Modal visor PDF --}}
    <div id="pdfModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        <div class="bg-white rounded-lg w-11/12 md:w-4/5 h-[85vh] flex flex-col shadow-xl">

            <div class="flex justify-between items-center px-4 py-3 border-b">
                <h3 class="text-lg font-semibold text-gray-700">
                    Vista previa del documento
                </h3>
                <button onclick="closePdfViewer()"
                        class="text-gray-500 hover:text-red-600 text-xl font-bold">
                    ✕
                </button>
            </div>

            <iframe
                id="pdfIframe"
                src=""
                class="w-full flex-1"
                frameborder="0">
            </iframe>

        </div>
    </div>

    <script>
        document.getElementById('file-upload')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            const maxSizeMB = 5;
            if (file) {
                if (file.size > maxSizeMB * 1024 * 1024) {
                    alert(`El archivo supera el máximo permitido de ${maxSizeMB}MB`);
                    e.target.value = "";
                    document.getElementById('file-name').textContent = "Ningún archivo seleccionado";
                } else {
                    document.getElementById('file-name').textContent = file.name;
                }
            }
        });
    </script>

    <script>
        document.getElementById('file-upload')?.addEventListener('change', function(e) {
            const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Ningún archivo seleccionado';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>

    <script>
        function openPdfViewer(url) {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');

            iframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePdfViewer() {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');

            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</x-app-layout>
