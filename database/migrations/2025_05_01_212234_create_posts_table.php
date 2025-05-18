<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(DB::raw('CURRENT_DATE'));
            $table->string('asesor');
            $table->string('cliente');
            $table->string('identificacion');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->string('provincia')->nullable();
            $table->string('canton')->nullable();
            $table->string('distrito')->nullable();
            $table->string('barrio')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ref_familia_1')->nullable();
            $table->string('num_familia_1')->nullable();
            $table->string('ref_familia_2')->nullable();
            $table->string('num_familia_2')->nullable();
            $table->string('ref_amistad')->nullable();
            $table->string('num_amistad')->nullable();
            $table->string('servicio')->nullable();
            $table->enum('deposito_garantia', ['si', 'no'])->default('no');
            $table->decimal('monto_deposito', 10, 2)->nullable();
            $table->string('tipo_telefono')->nullable();
            $table->string('tipo_activacion')->nullable();
            $table->string('numero_activar')->nullable();
            $table->string('canal_venta')->nullable();
            $table->timestamps();
            $table->string('estado')->default('Pendiente');
            $table->string('observaciones')->nullable();
            $table->boolean('Calibrado')->default(false);
            $table->string('comentario')->nullable();
        });

        Schema::create('asesors', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('prospeccion');
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('asesors');
    }
};
