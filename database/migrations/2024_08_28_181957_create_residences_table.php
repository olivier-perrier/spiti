<?php

use App\Models\Address;
use App\Models\Dispositif;
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
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('elevator')->default(false);
            $table->boolean('parking')->default(false);
            $table->string('heating')->nullable();
            $table->string('public_transport')->nullable();

            $table->foreignIdFor(Dispositif::class)->constrained();
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
        Schema::dropIfExists('residences');
    }
};
