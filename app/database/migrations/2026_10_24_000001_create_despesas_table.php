<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 150);
            $table->decimal('valor', 10, 2);
            $table->string('categoria', 30);
            $table->date('data')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
