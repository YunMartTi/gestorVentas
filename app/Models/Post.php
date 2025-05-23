<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Post extends Model
{

    use HasFactory;
    // protected $table = 'posts';

    /* Asignar los campos que se puedan llenar y enviar desde el formulario, para eviatar inyecciones
    protected $fillable = [
        'title',
        'slug',
        'content',
        'categoria',
        'published_at',
        'is_active',
    ];
    */
    // Asignar los campos que no se puedan llenar y enviar desde el formulario
    protected $guarded = [
        'id',
    ];
    //Caster a fecha la columna published_at y is_active
    protected function cast(): array
    {
        return [
            'published_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
    // Para poner todo lo que vaya a la columna title en minusculas
    protected function titLe(): Attribute
    {
        return Attribute::make(
            // Cuando inserta
            set: function ($value) {
                return strtolower($value);
            },
            // Cuando lee
            get: function ($value) {
                return ucfirst($value);
            }
            //El metodo set y get se conocen como mutadores y accesores
        );

    }
    public function getRouteKeyName()
    {
        return 'id';
    }
}
