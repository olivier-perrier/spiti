<?php

use App\Models\Dispositif;
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
        Schema::create('collective_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Dispositif::class)->constrained();
            $table->string('objectif')->nullable();
            $table->string('theme')->nullable();
            $table->string('subtheme')->nullable();
            $table->string('target')->nullable();
            $table->text('description')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('mobilisation')->default(false);
            $table->string('location')->nullable();

            $table->integer('participation')->nullable();
            $table->text('summary')->nullable();
            $table->text('status')->nullable();

            $table->foreignIdFor(Team::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_actions');
    }
};
