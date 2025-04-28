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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // this will store the user who created the service
                  ->constrained('users') // references id on users table
                  ->onDelete('cascade'); // if user is deleted, their services are deleted too
            $table->string('ServiceName');
            $table->string('ServiceDescription');
            $table->decimal('ServicePrice');
            $table->string('ServiceCategory');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('service', function (Blueprint $table) {
    //         $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::table('service', function (Blueprint $table) {
    //         $table->dropForeign(['user_id']);
    //         $table->dropColumn('user_id');
    //     });
    // }


    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
