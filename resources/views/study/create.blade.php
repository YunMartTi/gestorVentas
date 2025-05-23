<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Crear Estudio</h1>

    <form action="{{ route('study.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4 text-gray-700">
            <label for="cliente" class="block text-gray-700 font-bold mb-2">Cliente</label>
            <input type="text" id="cliente" name="cliente" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4 text-gray-700">
            <label for="tipo_documento" class="block text-gray-700 font-bold mb-2">Tipo de Documento</label>
            <select id="tipo_documento" name="tipo_documento" class="w-full border rounded px-3 py-2" required>
                <option value="Nacional">Nacional</option>
                <option value="Cedula residencia">Cedula residencia</option>
                <option value="Permiso laboral">Permiso laboral</option>
                <option value="Carnet de refugio">Carnet de refugio</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
        </div>

        <div class="mb-4 text-gray-700">
            <label for="cedula" class="block text-gray-700 font-bold mb-2">Identificación</label>
            <input type="text" id="cedula" name="cedula" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4 text-gray-700">
            <label for="servicio" class="block text-gray-700 font-bold mb-2">Servicio</label>
            <select id="servicio" name="servicio" class="w-full border rounded px-3 py-2" required>
                <option value="Pospago">Pospago</option>
                <option value="Pospago con equipo">Pospago con equipo</option>
                <option value="LFI">LFI</option>
                <option value="DTH">DTH</option>
                <option value="Gpon">Gpon</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enviar</button>
    </form>
</x-app-layout>
