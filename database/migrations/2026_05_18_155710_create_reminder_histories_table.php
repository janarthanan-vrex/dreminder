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
       Schema::create('reminder_histories', function (Blueprint $table) {

    $table->id();

    $table->unsignedBigInteger('user_id');

    $table->unsignedBigInteger('reminder_id');

    $table->date('reminder_date');

    $table->time('reminder_time');

    $table->string('status')->default('pending');

    $table->dateTime('sent_at')->nullable();

    $table->timestamps();

    /*
    |--------------------------------------------------------------------------
    | INDEXES
    |--------------------------------------------------------------------------
    */

    $table->index('user_id');

    $table->index('reminder_id');

    $table->index('reminder_date');

    $table->index('status');

    /*
    |--------------------------------------------------------------------------
    | FOREIGN KEYS
    |--------------------------------------------------------------------------
    */

    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');

    $table->foreign('reminder_id')
          ->references('id')
          ->on('reminders')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_histories');
    }
};
