<?php

use App\Models\Address;
use App\Models\Residence;
use App\Models\Team;
use App\Models\Type;
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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->integer('surface')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('agreed_capacity')->nullable();
            $table->boolean('PMR')->default(false);

            $table->foreignIdFor(Residence::class)->constrained();
            $table->foreignIdFor(Address::class)->nullable()->constrained();
            $table->foreignIdFor(Type::class)->nullable()->constrained();

            $table->foreignIdFor(Team::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
