<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_regresis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk_penjualans')->onDelete('cascade');
            $table->float('a');
            $table->float('b');
            $table->text('persamaan');
            $table->float('mape')->nullable();
            $table->integer('jan');
            $table->integer('feb');
            $table->integer('mar');
            $table->integer('apr');
            $table->integer('mei');
            $table->integer('jun');
            $table->integer('jul');
            $table->integer('agu');
            $table->integer('sep');
            $table->integer('okt');
            $table->integer('nov');
            $table->integer('des');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_regresis');
    }
};
