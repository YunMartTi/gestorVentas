<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Venta Pospago</h1>
    
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 border border-red-400 rounded p-4 w-full max-w-3xl mb-6">
            <h2 class="font-semibold">Errores:</h2>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  

    <form action="{{ route('posts.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-3xl">
        @csrf

        @php
            $fields = [
                ['label' => 'Asesor de ventas', 'name' => 'asesor'],
                ['label' => 'Nombres y apellidos del cliente', 'name' => 'cliente'],
                ['label' => 'Identificación', 'name' => 'identificacion'],
                ['label' => 'Número de contacto', 'name' => 'telefono'],
                ['label' => 'Correo electrónico', 'name' => 'email', 'type' => 'email'],
                ['label' => 'Provincia', 'name' => 'provincia'],
                ['label' => 'Distrito', 'name' => 'distrito'],
                ['label' => 'Barrio', 'name' => 'barrio'],
                ['label' => 'Dirección', 'name' => 'direccion'],
                ['label' => 'Referencia familia 1', 'name' => 'ref_familia_1'],
                ['label' => 'Número', 'name' => 'num_familia_1'],
                ['label' => 'Referencia familia 2', 'name' => 'ref_familia_2'],
                ['label' => 'Número', 'name' => 'num_familia_2'],
                ['label' => 'Referencia amistad', 'name' => 'ref_amistad'],
                ['label' => 'Número', 'name' => 'num_amistad'],
                ['label' => 'Servicio a vender', 'name' => 'servicio'],
                ['label' => 'Monto del depósito', 'name' => 'monto_deposito', 'type' => 'number'],
                ['label' => 'Tipo de teléfono', 'name' => 'tipo_telefono'],
                ['label' => 'Tipo de activación (Pospago)', 'name' => 'tipo_activacion'],
                ['label' => 'Número a activar', 'name' => 'numero_activar'],
                ['label' => 'Canal de venta', 'name' => 'canal_venta']
            ];
        @endphp


        @foreach ($fields as $field)
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="{{ $field['name'] }}">
                    {{ $field['label'] }}:
                </label>
                @if ($field['name'] == 'provincia')
                    <div class="mb-4">
                        {{-- Combo de provincias --}}
                        <select name="provincia" id="provincia"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Seleccione una provincia</option>
                            @foreach ($provincias as $id => $provinciaId)
                                <option value="{{ $id }}" {{ old('provincia') == $id ? 'selected' : '' }}>{{ $provinciaId }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="mb-4">
                        {{-- Combo de cantones (se llena dinámicamente) --}}
                        <label class="block text-gray-700 font-bold mb-2" for="canton">
                            Cantón:
                        </label>
                        <select name="canton" id="canton"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Seleccione una provincia primero</option>
                        </select>
                    </div>
                    
                    {{-- Script para cargar cantones dinámicamente --}}
                    <script>
                        document.getElementById('provincia').addEventListener('change', function () {
                            const provinciaId = this.value;
                            const cantonSelect = document.getElementById('canton');
                    
                            // Limpia el combo de cantones
                            cantonSelect.innerHTML = '<option value="">Cargando...</option>';
                    
                            if (provinciaId) {
                                fetch(`https://ubicaciones.paginasweb.cr/provincia/${provinciaId}/cantones.json`)                                    .then(response => response.json())
                                    .then(cantones => {
                                        cantonSelect.innerHTML = '<option value="">Seleccione un cantón</option>';
                                        for (const [id, nombre] of Object.entries(cantones)) {
                                            const option = document.createElement('option');
                                            option.value = id;
                                            option.text = nombre;
                                            cantonSelect.appendChild(option);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al cargar cantones:', error);
                                        cantonSelect.innerHTML = '<option value="">Error al cargar</option>';
                                    });
                            } else {
                                cantonSelect.innerHTML = '<option value="">Seleccione una provincia primero</option>';
                            }
                        });
                    </script>
                @elseif ($field['name'] == 'asesor')
                    <div class="form-group ">
                        <select name="asesor" id="asesor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                            <option value="">-- Selecciona un asesor --</option>
                            @foreach ($asesores as $asesor)
                                <option value="{{ $asesor->id }}">{{ $asesor->nombre ?? 'Sin nombre' }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" required
                    value="{{ old($field['name']) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @endif
            </div>
        @endforeach
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Depósito en garantía:</label>
            <select name="deposito_garantia"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="si" {{ old('deposito_garantia') == 'si' ? 'selected' : '' }}>Sí</option>
                <option value="no" {{ old('deposito_garantia') == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Crear venta
            </button>
        </div>
    </form>
</x-app-layout>
