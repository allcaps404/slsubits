<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('other_details', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('section');
        });
    }
    
    public function down()
    {
        Schema::table('other_details', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }    
};
