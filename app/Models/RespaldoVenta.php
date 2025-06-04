<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespaldoVenta extends Model
{
    use HasFactory;

    protected $table = 'respaldo_ventas';

    protected $fillable = [
        'id_cliente',
        'foto_frontal',
        'foto_posterior',
        'foto_cliente',
        'foto_sim',
        'visto_bueno_pdf',
    ];

    // Si tienes relación con ventas u otros modelos, puedes agregarlo aquí
    public function venta()
    {
        return $this->belongsTo(Post::class, 'id_cliente'); // asumiendo que Post es tu modelo de ventas
    }
}
