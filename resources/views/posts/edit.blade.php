<x-app-layout>
    <h1 class="text-2xl font-bold">Editar Venta</h1>

    <!-- Para validar si hay errores, y de ser así, indicarselo al usuario -->
    @if ($errors->any())
    <div class="alert alert-danger mb-4">
        <h2 class="text-red-500 font-bold">Errores</h2>
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-red-600">{{ $error }}</li> {{-- Mensaje de error --}}
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf {{-- Directiva de laravel para proteger el formulario contra ataques CSRF, envía un token --}}
        @method('PUT') {{-- Directiva de laravel para indicar que se va a hacer una actualización --}}

        <table class="table-auto w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Campo</th>
                    <th class="border px-4 py-2">Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Fecha</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="date" name="fecha" value="{{ old('fecha', $post->fecha) }}" class="w-full" required>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Asesor de ventas</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="asesor" value="{{ old('asesor', $post->asesor) }}" class="w-full" required>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Nombres y apellidos del cliente</td>
                    <td class="border px-4 py-2 text-gray-700">
                        <input type="text" name="cliente" value="{{ old('cliente', $post->cliente) }}" class="w-full" required>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Identificación</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="identificacion" value="{{ old('identificacion', $post->identificacion) }}" class="w-full" required>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Número de contacto</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="telefono" value="{{ old('telefono', $post->telefono) }}" class="w-full" required>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Correo electrónico</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="email" name="email" value="{{ old('email', $post->email) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Provincia</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="provincia" value="{{ old('provincia', $post->provincia) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Cantón</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="canton" value="{{ old('canton', $post->canton) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Distrito</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="distrito" value="{{ old('distrito', $post->distrito) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Barrio</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="barrio" value="{{ old('barrio', $post->barrio) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Dirección</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="direccion" value="{{ old('direccion', $post->direccion) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Referencia familia 1</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="ref_familia_1" value="{{ old('ref_familia_1', $post->ref_familia_1) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Número</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="num_familia_1" value="{{ old('num_familia_1', $post->num_familia_1) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Referencia familia 2</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="ref_familia_2" value="{{ old('ref_familia_2', $post->ref_familia_2) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Número</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="num_familia_2" value="{{ old('num_familia_2', $post->num_familia_2) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Referencia amistad</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="ref_amistad" value="{{ old('ref_amistad', $post->ref_amistad) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Número</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="num_amistad" value="{{ old('num_amistad', $post->num_amistad) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Servicio a vender</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="servicio" value="{{ old('servicio', $post->servicio) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Depósito en garantía</td>
                    <td class="border px-4 py-2 text-black">
                        <select name="deposito_garantia" class="w-full">
                            <option value="si" {{ old('deposito_garantia', $post->deposito_garantia) == 'si' ? 'selected' : '' }}>Sí</option>
                            <option value="no" {{ old('deposito_garantia', $post->deposito_garantia) == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Monto del depósito</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="number" name="monto_deposito" value="{{ old('monto_deposito', $post->monto_deposito) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Tipo de teléfono</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="tipo_telefono" value="{{ old('tipo_telefono', $post->tipo_telefono) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Tipo de activación</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="tipo_activacion" value="{{ old('tipo_activacion', $post->tipo_activacion) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Número a activar</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="numero_activar" value="{{ old('numero_activar', $post->numero_activar) }}" class="w-full">
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Canal de venta</td>
                    <td class="border px-4 py-2 text-black">
                        <input type="text" name="canal_venta" value="{{ old('canal_venta', $post->canal_venta) }}" class="w-full">
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600">
            Actualizar Venta
        </button>
    </form>
    <h1 class="text-2xl font-bold mb-4">Subir respaldo de venta</h1>

    
</x-app-layout>
