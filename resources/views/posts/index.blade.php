<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Ventas registradas</h1>

    <div class="flex justify-between items-center mb-4 rounded-xl">

        <details class="mb-4 bg-gray-100 p-4 rounded shadow-md open">
            <summary class="cursor-pointer font-semibold text-blue-600 mb-4">
                Filtros de búsqueda
            </summary>

            <form action="{{ route('posts.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                {{-- Cédula --}}
                <div>
                    <label for="cedula" class="text-sm text-gray-700">Cédula</label>
                    <input type="text" name="cedula" id="cedula"
                        value="{{ request('cedula') }}"
                        class="block px-3 py-2 border rounded-md text-gray-800 w-44">
                </div>

                {{-- Fecha exacta --}}
                <div>
                    <label for="fecha" class="text-sm text-gray-700">Fecha exacta</label>
                    <input type="date" name="fecha" id="fecha"
                        value="{{ request('fecha') }}"
                        class="block px-3 py-2 border rounded-md text-gray-800 w-44">
                </div>

                {{-- Tipo de venta --}}
                <div>
                    <label for="tipo" class="text-sm text-gray-700">Tipo</label>
                    <select name="tipo" id="tipo"
                            class="block px-3 py-2 border rounded-md text-gray-800 w-44">
                        <option value="">-- Todas --</option>
                        <option value="Pospago" {{ request('tipo') == 'Pospago' ? 'selected' : '' }}>Pospago</option>
                        <option value="Multimedia" {{ request('tipo') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                        <option value="Gpon" {{ request('tipo') == 'Gpon' ? 'selected' : '' }}>GPON</option>
                    </select>
                </div>

                {{-- Mes --}}
                <div>
                    <label for="mes" class="text-sm text-gray-700">Mes</label>
                    <select name="mes" id="mes"
                            class="block px-3 py-2 border rounded-md text-gray-800 w-32">
                        <option value="">--</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Año --}}
                <div>
                    <label for="anio" class="text-sm text-gray-700">Año</label>
                    <select name="anio" id="anio"
                            class="block px-3 py-2 border rounded-md text-gray-800 w-32">
                        <option value="">--</option>
                        @for ($year = now()->year; $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('anio') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        Limpiar filtros
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Buscar
                    </button>
                </div>
            </form>
        </details>
    </div>

    <div class="overflow-x-auto text-gray-700" >
        <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
            <thead class="bg-gray-200 text-gray-700 text-left">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Cliente</th>
                    <th class="px-6 py-3">Correo</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Calibrado</th>
                    <th class="px-6 py-3">Observaciones</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4">{{ $post->id }}</td>
                        <td class="px-6 py-4">{{ $post->fecha }}</td>
                        <td class="px-6 py-4">{{ $post->cliente }}</td>
                        <td class="px-6 py-4">{{ $post->email }}</td>
                        <td class="px-6 py-4">{{ $post->estado }}</td>
                        <td class="px-6 py-4">{{ $repCalibraciones->where('identificacion', $post->identificacion)->first()?->Calibrado ? 'Sí' : 'No' }}</td>
                        <td class="px-6 py-4">{{ $repCalibraciones->where('identificacion', $post->identificacion)->first()?->observaciones ?? '' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="text-blue-600 hover:underline">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    


    <div class="mt-4">
        {{ $posts->links() }} {{-- Paginación --}}
    </div>
</x-app-layout>


