<?php

use App\Models\Dispositif;
use App\Models\Partner;
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
        Schema::create('conventions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Dispositif::class)->constrained();
            $table->foreignIdFor(Partner::class)->constrained();

            $table->string('target')->nullable();
            $table->date('signature_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('start_date')->nullable();
            $table->string('status_id')->nullable();
            $table->string('funding')->nullable();
            $table->string('theme')->nullable();
            $table->string('subtheme')->nullable();
            $table->string('goals')->nullable();

            $table->foreignIdFor(Team::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventions');
    }
};
