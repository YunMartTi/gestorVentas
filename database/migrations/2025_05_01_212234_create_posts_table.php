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
            $table->string('tipo')->nullable();
            $table->string('numero_activar')->nullable();
            $table->string('canal_venta')->nullable();
            $table->timestamps();
            $table->string('estado')->default('Pendiente');
            $table->string('observaciones')->nullable();
        });
        Schema::create('reporte_activaciones', function (Blueprint $table) {
            $table->id();
            $table->string('id_venta');
            $table->string('identificacion');
            $table->string('activador');
            $table->string('observaciones')->nullable();
            $table->date('fecha_activacion')->default(DB::raw('CURRENT_DATE'));
            
        });

        Schema::create('reporte_calibraciones', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion');
            $table->string('id_venta');
            $table->boolean('Calibrado')->default(false);
            $table->string('calibrador');
            $table->string('comentario')->nullable();
            $table->date('fecha_calibracion')->default(DB::raw('CURRENT_DATE'));
        });

        Schema::table('reporte_activaciones', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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

        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->string('fecha')->default(DB::raw('CURRENT_DATE'));
            $table->string('asesor');
            $table->string('cliente');
            $table->string('tipo_documento');
            $table->string('cedula');
            $table->string('servicio');
            $table->string('respuesta')->nullable();
            $table->boolean('realizado')->default(false);
            $table->timestamps();
            //$table->foreignId('user_id')->constrained()->onDelete('cascade');
        });

        Schema::create('respaldo_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('id_cliente'); // o foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('foto_frontal');   // URL del archivo en Supabase
            $table->string('foto_posterior');
            $table->string('foto_cliente');
            $table->string('foto_sim')->nullable();
            $table->string('visto_bueno_pdf')->nullable(); // también será una URL
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('asesors');
        Schema::dropIfExists('reporte_activaciones');
        Schema::dropIfExists('reporte_calibraciones');
        Schema::dropIfExists('asesors');

    }
};
