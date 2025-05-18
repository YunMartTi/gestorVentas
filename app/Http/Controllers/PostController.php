<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Asesor;
use App\Http\Requests\StorePostRequest;
use App\Mail\PostCreatedMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\GeoCRService;

class PostController extends Controller
{

    public function Home()
    {
        $user = Auth::user();
        $mes = request('mes', now()->month);
        $anio = request('anio', now()->year);

        $inicioMes = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes = Carbon::create($anio, $mes, 1)->endOfMonth();

        $tipos = ['Pospago', 'Multimedia', 'Gpon'];
        $datos = [];

        if ($user->role === 'admin') {
            foreach ($tipos as $tipo) {
                $activas = DB::table('posts')
                    ->where('servicio', $tipo)
                    ->where('estado', 'Activa')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $pendientes = DB::table('posts')
                    ->where('servicio', $tipo)
                    ->where('estado', 'Pendiente')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $caidas = DB::table('posts')
                    ->where('servicio', $tipo)
                    ->where('estado', 'Caida')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $total = $activas + $pendientes + $caidas;

                $datos[$tipo] = compact('activas', 'pendientes', 'caidas', 'total');
            }
        } else {
            $asesor = DB::table('asesors')->where('user_id', $user->id)->first();
            if (!$asesor) {
                abort(403, 'Asesor no encontrado');
            }

            foreach ($tipos as $tipo) {
                $activas = DB::table('posts')
                    ->where('asesor', $asesor->nombre)
                    ->where('servicio', $tipo)
                    ->where('estado', 'Activa')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $pendientes = DB::table('posts')
                    ->where('asesor', $asesor->nombre)
                    ->where('servicio', $tipo)
                    ->where('estado', 'Pendiente')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $caidas = DB::table('posts')
                    ->where('asesor', $asesor->nombre)
                    ->where('servicio', $tipo)
                    ->where('estado', 'Caida')
                    ->whereBetween('fecha', [$inicioMes, $finMes])
                    ->count();

                $total = $activas + $pendientes + $caidas;

                $datos[$tipo] = compact('activas', 'pendientes', 'caidas', 'total');
            }
        }

        return view('posts.home', [
            'datosPospago' => $datos['Pospago'],
            'datosMultimedia' => $datos['Multimedia'],
            'datosGpon' => $datos['Gpon'],
        ]);
    }


    public function Provincias(GeoCRService $geoCRService)
    {
        $provincias = $geoCRService->getProvincias();
        return view('posts.create', compact('provincias')); // o return response()->json($provincias);
    }
    
    public function Cantones($provinciaId, GeoCRService $geoCRService)
    {
        $cantones = $geoCRService->getCantones($provinciaId);
        return view('posts.create', compact('provincias', 'asesores'));
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();

        $query = DB::table('posts');

        // Filtrar por asesor si no es admin
        if ($user->role !== 'admin') {
            $asesor = DB::table('asesors')->where('user_id', $userId)->first();
            if (!$asesor) {
                abort(403, 'Asesor no encontrado');
            }
            $query->where('asesor', $asesor->nombre);
        }
        // Filtro por tipo de venta
       if ($request->filled('tipo')) {
            $query->where('servicio', $request->tipo); // Asegúrate que el campo coincida
        }

        if ($request->filled('mes') && $request->filled('anio')) {
            $inicioMes = Carbon::create($request->anio, $request->mes, 1)->startOfMonth();
            $finMes = Carbon::create($request->anio, $request->mes, 1)->endOfMonth();
            $query->whereBetween('fecha', [$inicioMes, $finMes]);
        }

        // Filtro por cédula
        if ($request->filled('cedula')) {
            $query->where('identificacion', 'like', '%' . $request->cedula . '%');
        }

        // Filtro por fecha exacta
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }
        // Filtro por mes y año
        elseif ($request->filled('mes') && $request->filled('anio')) {
            $inicioMes = Carbon::create($request->anio, $request->mes, 1)->startOfMonth();
            $finMes = Carbon::create($request->anio, $request->mes, 1)->endOfMonth();
            $query->whereBetween('fecha', [$inicioMes, $finMes]);
        }
        // Si no se especifica nada, usar el mes actual
        else {
            $inicioMes = Carbon::now()->startOfMonth();
            $finMes = Carbon::now()->endOfMonth();
            $query->whereBetween('fecha', [$inicioMes, $finMes]);
        }

        $posts = $query->orderByDesc('id')->paginate(30);

        return view('posts.index', compact('posts'));
    }


    public function create(GeoCRService $geoCRService)
    {
        $asesores = Asesor::orderBy('nombre')->get(); // 👈 correcto
        $provincias = $geoCRService->getProvincias();
        return view('posts.create', compact('provincias', 'asesores'));
    }

    public function Show(Post $post)
    {   
        //Bucar en el post en la base de datos mediante el id
        // $post = Post::find($post);
        return view('posts.show', compact('post'));
    }
    public function store(StorePostRequest $request) //StorePostRequest para llamar al form request
    {
        Post::create($request->all());
        return redirect()->route('posts.index');
    }
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
    // Método para actualizar un post existente
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return redirect()->route('posts.show', $post)->with('success', 'Post editado con éxito');
        }
    public function destroy(Post $post)
    {
        // Eliminar el post de la base de datos
        $post->delete();
        // Redirigir a la lista de posts
        return redirect()->route('posts.index')->with('success', 'Post eliminado con éxito');
    }
}
