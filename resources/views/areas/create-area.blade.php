<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Área') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="container mx-auto px-4 py-8">
                <div class="max-w-3xl bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Crear Nueva Área</h2>                    
                    <form action="{{ route('area.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="abbreviation" class="block text-sm font-medium text-gray-700 mb-2">Abreviación</label>
                            <input type="text" name="abbreviation" id="abbreviation" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required></textarea>
                        </div>                        
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('area') }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
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

    <script>
        document.getElementById('abbreviation').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
        document.getElementById('description').addEventListener('input', function (event) {
            event.target.value = event.target.value.toUpperCase();
        });
    </script>
</x-app-layout>