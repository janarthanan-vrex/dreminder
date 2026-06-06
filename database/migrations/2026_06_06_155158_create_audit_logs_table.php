<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->string('event', 191);
            $table->string('module', 191);
            $table->string('module_icon', 191)->nullable();

            $table->unsignedBigInteger('admin_id')->nullable();

            $table->string('admin_name', 191);
            $table->string('admin_role', 191)->nullable();
            $table->string('admin_initials', 10)->nullable();
            $table->string('admin_color', 20)->nullable();
            $table->string('admin_bg', 20)->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->string('changes_summary', 191)->nullable();
            $table->json('changes_detail')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->nullOnDelete();

            // Separate indexes (avoids key length issues)
            $table->index('event');
            $table->index('module');
            $table->index('created_at');
            $table->index('admin_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};