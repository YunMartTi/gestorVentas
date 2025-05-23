<x-app-layout>
    <h1>Crear Nuevo Usuario</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class = "" action="{{ route('profile.store') }}" method="POST">
        @csrf

        <label for="name">Nombre:</label><br>
        <input type="text" class= "text-gray-700" name="name" required><br><br>

        <label for="cedula">Cédula:</label><br>
        <input type="text" class= "text-gray-700" name="cedula" required><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="text" class= "text-gray-700" name="telefono" required><br><br>

        <label for="prospeccion">Prospección:</label><br>
        <input type="text" class= "text-gray-700" name="prospeccion"><br><br>

        <label for="supervisor">Supervisor:</label><br>
        <input type="text" class= "text-gray-700" name="supervisor"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" class= "text-gray-700" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" class= "text-gray-700" name="password" required><br><br>
        <label for="password_confirmation">Confirmar Contraseña:</label><br>
        <input type="password" class="text-gray-700" name="password_confirmation" required><br><br>


        <label for="role">Rol:</label><br>
        <select class= "text-gray-700" name="role" required>
            <option value="admin">admin</option>
            <option value="asesor" selected>Asesor</option>
            <option value="activador">Activador</option>
            <option value="calibrador">Calibrador</option>
            <option value="supervisor">Supervisor</option>
        </select><br><br>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar Usuario</button>
    </form>
</x-app-layout>
