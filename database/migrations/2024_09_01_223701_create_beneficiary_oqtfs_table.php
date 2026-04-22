<?php

use App\Models\Beneficiary;
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
        Schema::create('beneficiary_oqtfs', function (Blueprint $table) {
            $table->id();
            $table->date('date_notification_48h')->nullable();
            $table->date('date_notification_15d')->nullable();
            $table->date('date_appeal')->nullable();
            $table->date('date_notification_TA')->nullable();
            $table->string('decision_TA')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();
            $table->foreignIdFor(Team::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_oqtfs');
    }
};
