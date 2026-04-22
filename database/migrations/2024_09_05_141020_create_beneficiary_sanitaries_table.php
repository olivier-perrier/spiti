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
        Schema::create('beneficiary_sanitaries', function (Blueprint $table) {
            $table->id();

            $table->string('health_monotoring')->nullable();
            $table->date('date_health_check')->nullable();
            $table->date('date_medical_visit')->nullable();
            $table->date('date_expeted_delivery')->nullable();
            $table->string('attending_doctor')->nullable();
            $table->string('comments')->nullable();

            $table->boolean('vitale_card')->default(false);
            $table->boolean('medical_support')->default(false);
            $table->boolean('health_issue')->default(false);
            $table->boolean('curatorship')->default(false);
            $table->boolean('guardianship')->default(false);
            $table->boolean('complementary')->default(false);
            $table->boolean('general_system')->default(false);

            /** Situation entry */
            // Base
            $table->string('title_medical_care_entry')->nullable();
            $table->date('date_start_medical_care_entry')->nullable();
            $table->date('date_end_medical_care_entry')->nullable();

            // Health care complementary
            $table->string('title_medical_care_supplementary_entry')->nullable();
            $table->date('date_start_medical_care_supplementary_entry')->nullable();
            $table->date('date_end_medical_care_supplementary_entry')->nullable();

            /** Démarches / Suivi */
            // Base
            $table->string('title_medical_care')->nullable();
            $table->date('date_deposit_medical_care')->nullable();
            $table->date('date_start_medical_care')->nullable();
            $table->date('date_end_medical_care')->nullable();

            // Health care complementary
            $table->string('title_medical_care_supplementary')->nullable();
            $table->date('date_deposit_medical_care_supplementary')->nullable();
            $table->date('date_start_medical_care_supplementary')->nullable();
            $table->date('date_end_medical_care_supplementary')->nullable();

            $table->foreignIdFor(Beneficiary::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_sanitaries');
    }
};
