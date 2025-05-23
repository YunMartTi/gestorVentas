<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Study extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'asesor',
        'cliente',
        'tipo_documento',
        'cedula',
        'servicio',
        'respuesta',
        'realizado'
    ];

    protected $guarded = [
        'id',
    ];
}
