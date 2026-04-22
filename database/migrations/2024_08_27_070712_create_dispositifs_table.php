<?php

use App\Models\Address;
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
        Schema::create('dispositifs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('opening_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('finess_number')->nullable();
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
        Schema::dropIfExists('dispositifs');
    }
};
