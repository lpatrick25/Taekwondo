<?php

use App\Enums\TournamentStatus;
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
        Schema::create('kyorugi_tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_category_id')->constrained('event_categories')->onDelete('cascade');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('registration_start');
            $table->date('registration_end');
            $table->string('venue_name')->nullable();

            $table->string('province_code')->nullable();
            $table->string('municipality_code')->nullable();
            $table->string('brgy_code')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->string('status')->default(TournamentStatus::DRAFT->value);
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyorugi_tournaments');
    }
};
