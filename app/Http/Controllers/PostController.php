<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Mail\PostCreatedMail;
use App\Models\Asesor;
use App\Models\Post;
use App\Models\Study;
use App\Services\GeoCRService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function showStudy()
    {
        $estudios = DB::table('studies')->paginate(20);
        return view('study.show', compact('estudios'));
    }

    public function createEstudio()
    {
        return view('study.create');
    }

    public function updateEstudio(Study $study)
    {
        $study->update(['respuesta' => request('respuesta')]);
        return redirect()->back()->with('success', 'Venta marcada como activa.');
    }

    public function storeStudy(StorePostRequest $request)
    {
        Study::create(array_merge($request->only([
            'cliente', 'tipo_documento', 'cedula', 'servicio'
        ]), [
            'respuesta' => '',
            'fecha' => now(),
            'asesor' => Auth::id(),
        ]));
        return redirect()->back()->with('success', 'Estudio creado con éxito.');
    }

    public function Home()
    {
        $user = Auth::user();
        $mes = request('mes', now()->month);
        $anio = request('anio', now()->year);

        $inicioMes = Carbon::create($anio, $mes)->startOfMonth();
        $finMes = Carbon::create($anio, $mes)->endOfMonth();

        $repCalibraciones = DB::table('reporte_calibraciones')->get();
        $datos = collect();

        $query = DB::table('posts')
            ->select('servicio', 'estado', DB::raw('count(*) as total'))
            ->whereBetween('fecha', [$inicioMes, $finMes]);

        if ($user->role !== 'admin') {
            $asesor = DB::table('asesors')->where('user_id', $user->id)->firstOrFail();
            $query->where('asesor', $asesor->nombre);
        }

        $resultados = $query->groupBy('servicio', 'estado')->get();

        foreach (['Pospago', 'Multimedia', 'Gpon'] as $tipo) {
            $tipos = $resultados->where('servicio', $tipo);
            $datos[$tipo] = [
                'activas' => $tipos->where('estado', 'Activa')->first()?->total ?? 0,
                'pendientes' => $tipos->where('estado', 'Pendiente')->first()?->total ?? 0,
                'caidas' => $tipos->where('estado', 'Caida')->first()?->total ?? 0,
                'total' => $tipos->sum('total'),
                'repCalibraciones' => $repCalibraciones,
            ];
        }

        return view('posts.home', [
            'datosPospago' => $datos['Pospago'],
            'datosMultimedia' => $datos['Multimedia'],
            'datosGpon' => $datos['Gpon'],
            'repCalibraciones' => $repCalibraciones,
        ]);
    }

    public function Activar(Post $post)
    {
        $post->update(['estado' => 'Activa']);
        return redirect()->back()->with('success', 'Venta marcada como activa.');
    }

    public function Caida(Post $post)
    {
        $post->update(['estado' => 'Caida']);
        return redirect()->back()->with('success', 'Venta marcada como caída.');
    }

    public function Pendiente(Post $post)
    {
        $post->update(['estado' => 'Pendiente']);
        return redirect()->back()->with('success', 'Venta marcada como pendiente.');
    }

    public function Calibrar(Post $post, Request $request)
    {
        $request->validate(['comentario' => 'required|string|max:1000']);
        $user = Auth::user();

        $existe = DB::table('reporte_calibraciones')->where('id_venta', $post->id)->exists();
        if (!$existe) {
            DB::table('reporte_calibraciones')->insert([
                'id_venta' => $post->id,
                'identificacion' => $post->identificacion,
                'Calibrado' => true,
                'comentario' => $request->input('comentario'),
                'calibrador' => $user->cedula,
                'fecha_calibracion' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Venta calibrada.');
    }

    public function Observaciones(Post $post, Request $request)
    {
        $post->update(['observaciones' => $request->input('observaciones')]);
        return redirect()->back()->with('success', 'Observaciones guardadas.');
    }

    public function Provincias(GeoCRService $geoCRService)
    {
        return view('posts.create', [
            'provincias' => $geoCRService->getProvincias(),
        ]);
    }

    public function Cantones($provinciaId, GeoCRService $geoCRService)
    {
        return response()->json($geoCRService->getCantones($provinciaId));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $repCalibraciones = DB::table('reporte_calibraciones')->get();

        $query = DB::table('posts');
        if ($user->role !== 'admin') {
            $asesor = DB::table('asesors')->where('user_id', $user->id)->firstOrFail();
            $query->where('asesor', $asesor->nombre);
        }

        if ($request->filled('tipo')) {
            $query->where('servicio', $request->tipo);
        }

        if ($request->filled('cedula')) {
            $query->where('identificacion', 'like', "%{$request->cedula}%");
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        } else {
            $inicioMes = Carbon::create($request->anio ?? now()->year, $request->mes ?? now()->month)->startOfMonth();
            $finMes = Carbon::create($request->anio ?? now()->year, $request->mes ?? now()->month)->endOfMonth();
            $query->whereBetween('fecha', [$inicioMes, $finMes]);
        }

        $posts = $query->orderByDesc('id')->paginate(30);
        return view('posts.index', compact('posts', 'repCalibraciones'));
    }

    public function create(GeoCRService $geoCRService)
    {
        return view('posts.create', [
            'asesores' => Asesor::orderBy('nombre')->get(),
            'provincias' => $geoCRService->getProvincias(),
        ]);
    }

    public function Show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'repCalibraciones' => DB::table('reporte_calibraciones')->get(),
            'repActivaciones' => DB::table('reporte_activaciones')->get(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        Post::create($request->validated());
        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return redirect()->route('posts.show', $post)->with('success', 'Post editado con éxito');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post eliminado con éxito');
    }
}
