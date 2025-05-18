<x-app-layout>

    <form method="GET" action="{{ route('home') }}" class="mb-6 text-gray-700">
        <div class="flex items-center gap-4">
            <div>
                <label for="mes" class="block text-white font-semibold">Mes</label>
                <select name="mes" id="mes" class="rounded-md p-2">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('mes', now()->month) == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

           <div class="">
                <label for="anio" class="block text-white font-semibold">Año</label>
                <select name="anio" id="anio" class="rounded-md p-2 w-32">
                    @for ($year = now()->year; $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ request('anio', now()->year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Filtrar
                </button>
            </div>
        </div>
    </form>


    <div class="flex gap-6 overflow-auto">
        {{-- POSPAGO --}}
        <div class="border-2 border-gray-300 rounded-lg p-6">
            <h1 class="text-xl font-bold mb-4 text-white text-center">Pospago</h1>
            <div class="overflow-x-auto text-gray-700">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <tbody class="divide-y divide-gray-200">
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Activas</th><td class="px-6 py-4">{{ $datosPospago['activas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Pendientes</th><td class="px-6 py-4">{{ $datosPospago['pendientes'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Caídas</th><td class="px-6 py-4">{{ $datosPospago['caidas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Total</th><td class="px-6 py-4">{{ $datosPospago['total'] }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MULTIMEDIA --}}
        <div class="border-2 border-gray-300 rounded-lg p-6">
            <h1 class="text-xl font-bold mb-4 text-white text-center">Multimedia</h1>
            <div class="overflow-x-auto text-gray-700">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <tbody class="divide-y divide-gray-200">
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Activas</th><td class="px-6 py-4">{{ $datosMultimedia['activas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Pendientes</th><td class="px-6 py-4">{{ $datosMultimedia['pendientes'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Caídas</th><td class="px-6 py-4">{{ $datosMultimedia['caidas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Total</th><td class="px-6 py-4">{{ $datosMultimedia['total'] }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- GPON --}}
        <div class="border-2 border-gray-300 rounded-lg p-6">
            <h1 class="text-xl font-bold mb-4 text-white text-center">GPON</h1>
            <div class="overflow-x-auto text-gray-700">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <tbody class="divide-y divide-gray-200">
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Activas</th><td class="px-6 py-4">{{ $datosGpon['activas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Pendientes</th><td class="px-6 py-4">{{ $datosGpon['pendientes'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Caídas</th><td class="px-6 py-4">{{ $datosGpon['caidas'] }}</td></tr>
                        <tr><th class="px-6 py-3 text-left bg-gray-200">Total</th><td class="px-6 py-4">{{ $datosGpon['total'] }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <br>
</x-app-layout>

