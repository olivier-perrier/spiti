<?php

use App\Models\CollectiveAction;
use App\Models\Partner;
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
        Schema::create('collective_action_partner', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Partner::class);
            $table->foreignIdFor(CollectiveAction::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collective_action_partner');
    }
};
