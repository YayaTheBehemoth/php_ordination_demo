<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ordinationer', function (Blueprint $table) {
            $table->id();

            $table->string('type')->index(); // STI discriminator

            $table->foreignId('laegemiddel_id')
                ->constrained('laegemiddler')
                ->cascadeOnDelete();

            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patienter')
                ->nullOnDelete();

            $table->date('start_den');
            $table->date('slut_den');

            // PN-specific
            $table->double('antal_enheder', 8, 2)->nullable();

            // DagligFast-specific
            $table->foreignId('morgen_dosis_id')->nullable()->constrained('doser')->nullOnDelete();
            $table->foreignId('middag_dosis_id')->nullable()->constrained('doser')->nullOnDelete();
            $table->foreignId('aften_dosis_id')->nullable()->constrained('doser')->nullOnDelete();
            $table->foreignId('nat_dosis_id')->nullable()->constrained('doser')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordinationer');
    }
};

