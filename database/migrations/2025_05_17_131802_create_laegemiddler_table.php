<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('laegemiddler', function (Blueprint $table) {
        $table->id();
        $table->string('navn');
        $table->double('enhedPrKgPrDoegnLet');
        $table->double('enhedPrKgPrDoegnNormal');
        $table->double('enhedPrKgPrDoegnTung');
        $table->string('enhed');
      
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laegemiddler');
    }
};
