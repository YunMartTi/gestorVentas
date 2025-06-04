<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\RespaldoVenta;
use Illuminate\Support\Facades\Log;

class RespaldoController extends Controller
{

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_cliente' => 'required',
                'foto_frontal' => 'required|file|image',
                'foto_posterior' => 'required|file|image',
                'foto_cliente' => 'required|file|image',
                'foto_sim' => 'nullable|file|image',
                'visto_bueno_pdf' => 'nullable|file|mimes:pdf',
            ]);

            $bucket = 'gestorventas';
            $folder = 'respaldo_ventas/' . $request->id_cliente;
            $urls = [];
            $baseUrl = env('SUPABASE_URL');

            foreach (['foto_frontal', 'foto_posterior', 'foto_cliente', 'foto_sim', 'visto_bueno_pdf'] as $field) {
                if ($request->hasFile($field)) {
                    
                    $file = $request->file($field);
                    $filename = $field . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $uploadUrl = "$baseUrl/storage/v1/object/$bucket/$folder/$filename";
                    $publicUrl = "$baseUrl/storage/v1/object/public/$bucket/$folder/$filename";
                    
                    $response = Http::withHeaders([
                        'apikey' => env('SUPABASE_API_KEY'),
                        'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                        'Content-Type' => $file->getMimeType(),
                    ])->withBody(
                        fopen($file->getPathname(), 'r'), $file->getMimeType()
                    )->put($uploadUrl);
                        
                    if ($response->successful()) {
                        $urls[$field] = $publicUrl;
                    } else {
                        return back()->withErrors([
                            'upload' => "Error subiendo $field: " . $response->body()
                        ]);
                    }
                }
            }

            RespaldoVenta::create([
                'id_cliente' => $request->id_cliente,
                'foto_frontal' => $urls['foto_frontal'] ?? null,
                'foto_posterior' => $urls['foto_posterior'] ?? null,
                'foto_cliente' => $urls['foto_cliente'] ?? null,
                'foto_sim' => $urls['foto_sim'] ?? null,
                'visto_bueno_pdf' => $urls['visto_bueno_pdf'] ?? null,
            ]);

            return redirect()->back()->with('success', 'Respaldo guardado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error en RespaldoController@store: ' . $e->getMessage());
            return back()->withErrors(['exception' => $e->getMessage()]);
        }
    }
    public function getSignedUrl($path)
    {
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('SUPABASE_URL') . '/storage/v1/object/sign/' . $path, [
            'expiresIn' => 3600 // 1 hora
        ]);

        if ($response->successful()) {
            return redirect($response->json('signedURL'));
        } else {
            return response()->json([
                'error' => 'No se pudo generar el enlace firmado',
                'details' => $response->json()
            ], 500);
        }
    }


}
