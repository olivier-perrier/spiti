<?php

use App\Models\Beneficiary;
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
        Schema::create('beneficiary_justices', function (Blueprint $table) {
            $table->id();

            $table->string('orienteer')->nullable();
            $table->string('cpip')->nullable();
            $table->string('dentention_place')->nullable();
            $table->date('detention_start')->nullable();
            $table->date('date_cap')->nullable();
            $table->date('detention_end')->nullable();
            $table->string('court_procedure')->nullable();
            $table->string('procedure_duration')->nullable();

            $table->json('obligations')->nullable();
            $table->json('prohibitions')->nullable();

            $table->date('date_adjustment_request')->nullable();
            $table->boolean('adjustment_refused')->default(false);
            $table->string('adjustment_description')->nullable();
            $table->string('adjustment_durantion')->nullable();
            $table->boolean('tig_compelled')->default(false);
            $table->string('internship')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_justices');
    }
};
