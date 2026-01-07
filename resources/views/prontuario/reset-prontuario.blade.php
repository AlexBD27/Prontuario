<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reiniciar Prontuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Reiniciar Prontuario</h2>

                    <form id="tramiteForm" action="{{ route('prontuario.reset') }}" method="POST">
                        @csrf
                        <div class="mt-6 flex items-center space-x-4">
                            <a href="{{ route('dashboard.admin') }}"
                                class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out mr-4">
                                 Cancelar
                             </a>
                            <button id="resetbtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('resetbtn').addEventListener('click', function (event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de querer reiniciar el prontuario?',
                text: "Recuerda que es una acción que no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, reiniciar',
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
        @if(session('success'))
            Swal.fire({
                title: 'HECHO',
                text: 'Se ha reiniciado el Prontuario',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            });
        @endif
    </script>

</x-app-layout>