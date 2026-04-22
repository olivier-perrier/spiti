<?php

use App\Models\Address;
use App\Models\Dispositif;
use App\Models\Team;
use App\Models\User;
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
        Schema::create('menages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->date('date_entry')->nullable();
            // $table->string('preview_accommodation_id')->nullable()->references('id')->on('types');
            $table->boolean('has_social_right')->default(false);
            $table->string('badge_key')->nullable();
            $table->boolean('animal')->default(false);
            $table->string('animal_type')->nullable();

            $table->foreignIdFor(Dispositif::class)->nullable()->constrained();
            $table->foreignIdFor(User::class, 'referent_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignIdFor(Address::class)->nullable()->constrained();

            // $table->foreignId('orientation_id')->nullable()->constrained();
            // $table->foreignId('family_composition_id')->nullable()->references('id')->on('types');

            // $table->foreignId('domiciliation_id')->nullable()->constrained();

            $table->foreignIdFor(Team::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menages');
    }
};
