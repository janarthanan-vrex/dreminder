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
        Schema::create('user_notification_settings', function (Blueprint $table) {

    $table->id();

    $table->unsignedBigInteger('user_id');

    // Notification channels
    $table->boolean('email_notify')->default(true);
    $table->boolean('push_notify')->default(false);

    // Alert timings
    $table->boolean('before_30_days')->default(false);
    $table->boolean('before_7_days')->default(false);
    $table->boolean('before_3_days')->default(false);
    $table->boolean('before_1_day')->default(false);
    $table->boolean('on_day')->default(false);

    $table->timestamps();

    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_settings');
    }
};
