<x-app-layout>
    <div class="bg-gray-800 text-white">
        <h1 class="text-2xl font-bold">Estado: {{ $post->estado }}</h1>
    </div>
    <div class = "flex gap-6 overflow-auto">
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md mt-10 rounded-xl">
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">
                ← Volver a la lista de ventas
            </a>

            <br>
            <h1 class="text-2xl font-bold mt-4 mb-2 text-gray-600">Asesor de ventas: {{ $post->asesor }}</h1>
            <br>
            <div class="mb-4 text-gray-600">
                <strong>Cliente:</strong><br>
                {{ $post->cliente }} <br>
                <strong>Identificación:</strong> <br>
                {{ $post->identificacion }} <br>
                <strong>Número de contacto:</strong> <br>
                {{ $post->telefono }} <br>
                <strong >Correo electrónico:</strong> <br>
                {{ $post->email }} <br>
            </div>

            <br>
            <div class="mb-4 text-gray-600">
                <p><strong>Dirección:</strong></p>
                <p>{{ $post->direccion }} </p>
                <p><strong>Referencia familia 1:</strong></p>
                <p>{{ $post->ref_familia_1 }} </p>
                <p><strong>Número:</strong> {{ $post->num_familia_1 }} </p>
                <p><strong>Referencia familia 2:</strong></p>
                <p>{{ $post->ref_familia_2 }} </p>
                <p><strong>Número:</strong> {{ $post->num_familia_2 }} </p>
                <p><strong>Referencia amistad:</strong></p>
                <p>{{ $post->ref_amistad }} </p>
                <p><strong>Número:</strong> {{ $post->num_amistad }} </p>
            </div>

            <br>
            <div class="mb-4 text-gray-600">
                <p><strong>Servicio a vender:</strong> {{ $post->servicio }} </p>
                <p><strong>Depósito en garantía:</strong> {{ $post->deposito_garantia == 'si' ? 'Sí' : 'No' }} </p>
                <p><strong>Monto del depósito:</strong> {{ $post->monto_deposito }} </p>
                <p><strong>Tipo de teléfono:</strong> {{ $post->tipo_telefono }} </p>
                <p><strong>Tipo de activación:</strong> {{ $post->tipo_activacion }} </p>
                <p><strong>Número a activar:</strong> {{ $post->numero_activar }} </p>
                <p><strong>Canal de venta:</strong> {{ $post->canal_venta }} </p>
            </div>

            <br>
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="flex items-center space-x-4 mt-4">
                        <a href="{{ route('posts.edit', $post) }}"
                        class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">
                            Editar venta
                        </a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                Eliminar venta
                            </button>
                        </form>

                    </div>
                @endif
            @endauth
        </div>
        <!--Zona de calibradores-->
        <div class="flex gap-6 overflow-auto">
            {{-- POSPAGO --}}
            <div class="border-2 border-gray-300 rounded-lg p-6">
                <h1 class="text-xl font-bold mb-4 text-white text-center">Información</h1>
                <div class="overflow-x-auto text-gray-700">
                    <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                        <tbody class="divide-y divide-gray-200">
                            <tr><th class="px-6 py-3 text-left bg-gray-200">Observaciones:</th><td class="px-6 py-4">{{ $post->observaciones }}</td></tr>    
                            <tr><th class="px-6 py-3 text-left bg-gray-200">Calibrada:</th><td class="px-6 py-4">{{ $repCalibraciones->where('identificacion', $post->identificacion)->first()?->Calibrado ? 'Sí' : 'No' }}</td></tr>
                            <tr><th class="px-6 py-3 text-left bg-gray-200">Comentario:</th><td class="px-6 py-4">{{ $repCalibraciones->where('identificacion', $post->identificacion)->first()?->comentario ?? '' }}</td></tr>    
                        </tbody>
                    </table>
                    
                </div>
                <br>
                @auth
                    @if(auth()->user()->role === 'calibrador' || auth()->user()->role === 'admin')

                        <form action="{{ route('posts.calibrar', $post->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <label for="comentario">Comentario:</label>
                            <textarea name="comentario" id="comentario" rows="4" class="w-full border rounded-md p-2 text-gray-700"></textarea>

                            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition mt-2">
                                Marcar como calibrada
                            </button>
                        </form>
                    @endif
                    @if (in_array(auth()->user()->role, ['admin', 'supervisor', 'activador']))
                        <br>
                        <label for="comentario">Observaciones:</label>
                        <textarea name="comentario" id="comentario" rows="4" class="w-full border rounded-md p-2 text-gray-700"></textarea>
                        <br>
                        @php
                            $calibracion = $repCalibraciones->firstWhere('id_venta', $post->id);
                        @endphp

                        @if($calibracion && $calibracion->Calibrado)
                            <form action="{{ route('posts.activar', $post) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition mt-2">
                                    Marcar como activada
                                </button>
                            </form>
                        @endif     
                        <br>

                    @endif
                @endauth
                <form action="{{ route('respaldo.store') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto bg-white p-6 rounded shadow">
                                @csrf

                                <input type="hidden" name="id_cliente" value="{{ $post->id }}">

                                @php
                                    $fields = [
                                        'foto_frontal' => 'Foto frontal cédula',
                                        'foto_posterior' => 'Foto posterior cédula',
                                        'foto_cliente' => 'Foto cliente con SIM',
                                        'foto_sim' => 'Foto del SIM',
                                        'visto_bueno_pdf' => 'PDF de visto bueno',
                                    ];
                                @endphp

                                @foreach ($fields as $name => $label)
                                    <div class="mb-4">
                                        <label class="block text-gray-700">{{ $label }}</label>
                                        <div class="flex items-center gap-2">
                                            <input 
                                                type="file" 
                                                name="{{ $name }}" 
                                                id="{{ $name }}" 
                                                @if (!Str::contains($name, 'pdf')) accept="image/*" @else accept=".pdf" @endif
                                                class="w-full border rounded px-3 py-2 file-input"
                                                @if (in_array($name, ['foto_frontal', 'foto_posterior', 'foto_cliente'])) required @endif
                                            >
                                            <span id="{{ $name }}_check" class="text-green-600 hidden">✅</span>
                                        </div>
                                    </div>
                                @endforeach

                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Subir respaldo</button>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const fields = ['foto_frontal', 'foto_posterior', 'foto_cliente', 'foto_sim', 'visto_bueno_pdf'];

                                    fields.forEach(name => {
                                        const input = document.getElementById(name);
                                        const check = document.getElementById(name + '_check');

                                        input.addEventListener('change', () => {
                                            if (input.files.length > 0) {
                                                check.classList.remove('hidden');
                                            } else {
                                                check.classList.add('hidden');
                                            }
                                        });
                                    });
                                });
                            </script>

                        <br>    <!-- Espacio para separación -->
                            @if($post->respaldo)
                                <div class="mt-6 bg-white p-6 rounded shadow">
                                    <h2 class="text-lg font-bold mb-4 text-gray-700">Archivos Subidos</h2>

                                    @php
                                        $fields = [
                                            'foto_frontal' => 'Foto frontal cédula',
                                            'foto_posterior' => 'Foto posterior cédula',
                                            'foto_cliente' => 'Foto cliente con SIM',
                                            'foto_sim' => 'Foto del SIM',
                                            'visto_bueno_pdf' => 'PDF de visto bueno',
                                        ];
                                    @endphp

                                    @foreach ($fields as $field => $label)
                                        @php $url = $post->respaldo->$field; @endphp
                                        @if($url)
                                            <div class="mb-4 text-gray-700">
                                                <strong class="text-gray-800">{{ $label }}:</strong><br>

                                                @php
                                                    $urlWithoutQuery = explode('?', $url)[0];
                                                    $path = Str::after($urlWithoutQuery, 'storage/v1/object/public/');
                                                @endphp

                                                @if(Str::endsWith($url, '.pdf'))
                                                    <a href="{{ route('respaldo.ver', ['path' => $path]) }}" target="_blank">
                                                        Ver PDF
                                                    </a>
                                                @else
                                                    <a href="{{ route('respaldo.ver', ['path' => $path]) }}" target="_blank">
                                                        Ver imagen segura
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach



                                </div>
                            @endif
            </div>
            
        </div>
        
    </div>
    
</x-app-layout>

