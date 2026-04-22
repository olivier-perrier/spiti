<?php

use App\Models\Address;
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
        Schema::create('beneficiary_education', function (Blueprint $table) {
            $table->id();

            $table->string('school_level')->nullable();
            $table->string('diploma')->nullable();
            $table->string('languages')->nullable();
            $table->string('equivalence_ENIC')->nullable();

            $table->string('french_oral_level')->nullable();
            $table->string('french_written_level')->nullable();
            $table->string('french_diploma_level')->nullable();
            $table->date('date_french_diploma')->nullable();

            $table->string('school_situation')->nullable();
            $table->string('school_name')->nullable();
            $table->string('reason_no_school')->nullable();
            $table->boolean('special_class')->default(false);

            $table->foreignIdFor(Address::class, 'school_address_id')->nullable()->constrained('addresses');
            $table->foreignIdFor(Beneficiary::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_education');
    }
};
