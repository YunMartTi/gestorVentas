@push('css')
    <style>
    body {
        background-color: rgb(69, 11, 69);
        color: white;
        font-family: 'Arial', sans-serif;
    }

    </style>
@endpush
 
<x-app-layout>

    <!-- Se llama la alerte y se le envía por parametro el título y el contenido de la alerta -->
    <div class="mx-auto px-15">
        <h1>Welcome to our main page</h1>

        <x-Alerts2 type="info" class="mb-4">
            {{-- Tipo de alerta (info, danger, success...) --}}
            <x-slot name="title">
                Advisement {{-- Título de la alerta --}}
            </x-slot>
            Contenido de la alerta {{-- Mensaje de la alerta --}}
        </x-Alerts2>
        <p> Hola mundo</p>
    </div>    

</x-app-layout>
