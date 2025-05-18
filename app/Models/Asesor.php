<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asesor extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'id';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
