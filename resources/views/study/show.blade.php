<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Estudios</h1> 

    <div class="flex justify-end mb-4">
        <a href="{{ route('study.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo</a>
    </div>

    <div class="overflow-x-auto text-gray-700">
        <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
            <thead class="bg-gray-200 text-gray-700 text-left">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Asesor</th>
                    <th class="px-6 py-3">Cliente</th>
                    <th class="px-6 py-3">Tipo documento</th>
                    <th class="px-6 py-3">Cedula</th>
                    <th class="px-6 py-3">Servicio</th>
                    <th class="px-6 py-3">Respuesta</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($estudios as $estudio)
                    <tr>
                        <td class="px-6 py-4">{{ $estudio->id }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($estudio->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $estudio->asesor }}</td>
                        <td class="px-6 py-4">{{ $estudio->cliente }}</td>
                        <td class="px-6 py-4">{{ $estudio->tipo_documento }}</td>
                        <td class="px-6 py-4">{{ $estudio->cedula }}</td>
                        <td class="px-6 py-4">{{ $estudio->servicio }}</td>
                       <td class="border px-4 py-2 text-black">
                        <form action="{{ route('study.update', $estudio->id) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="text" name="respuesta" value="{{ old('respuesta', $estudio->respuesta) }}" class="w-full text-black">
                        </td>
                        <td class="px-6 py-4">
                                <button type="submit" class="text-blue-600 hover:underline">Enviar</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>