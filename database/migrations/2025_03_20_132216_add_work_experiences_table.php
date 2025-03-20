<?php

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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('position'); // Job position
            $table->string('company_name'); // Name of the company
            $table->string('contact_number')->nullable(); // Contact number (optional)
            $table->date('start_date'); // Start date of the job
            $table->date('end_date')->nullable(); // End date of the job (nullable if currently working)
            $table->boolean('currently_working')->default(false); // Indicates if the user is currently working here
            $table->text('description')->nullable(); // Job description or responsibilities (optional)
            $table->string('respondent_affiliation')->nullable(); // Affiliation of the respondent (e.g., department/team)
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};