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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description');  // Short description
            $table->dateTime('event_date');  // Event date
            $table->dateTime('login_datetime');  // Login datetime
            $table->dateTime('logout_datetime');  // Logout datetime
            $table->string('academic_year');  // Academic year
            $table->string('semester');  // Semester
            $table->timestamps();  // Laravel's created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
