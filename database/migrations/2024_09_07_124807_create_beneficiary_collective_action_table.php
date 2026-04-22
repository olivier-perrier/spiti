<?php

use App\Models\Beneficiary;
use App\Models\CollectiveAction;
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
        Schema::create('beneficiary_collective_action', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Beneficiary::class);
            $table->foreignIdFor(CollectiveAction::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_collective_action');
    }
};
