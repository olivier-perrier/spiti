<?php

use App\Models\Lot;
use App\Models\Menage;
use App\Models\Team;
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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birth_name')->nullable();
            $table->string('AGDREF')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthday')->nullable();
            $table->string('nationality')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('birth_city')->nullable();
            $table->date('date_entry_dispositif')->nullable();
            $table->date('date_arrival_france')->nullable();

            $table->foreignId('family_situation_id')->nullable()->constrained()->references('id')->on('types');
            $table->foreignId('administrative_situation_id')->nullable()->constrained()->references('id')->on('types');

            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('email')->nullable();

            $table->foreignIdFor(Lot::class)->nullable()->constrained();
            $table->foreignIdFor(Menage::class, 'menage_id')->nullable()->constrained();

            // $table->foreignId('situation_id')->nullable()->references('id')->on('types');

            // $table->foreignId('education_level_id')->nullable()->constrained();
            // $table->foreignId('work_procedure_id')->nullable()->constrained();

            $table->foreignIdFor(Team::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
