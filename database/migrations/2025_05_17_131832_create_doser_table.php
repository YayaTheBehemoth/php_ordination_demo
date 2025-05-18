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
    Schema::create('doser', function (Blueprint $table) {
        $table->id();
        $table->dateTime('tidspunkt');
        $table->double('antal');
        $table->foreignId('ordination_id')->nullable()->constrained('ordinationer')->nullOnDelete();
     
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doser');
    }
};
