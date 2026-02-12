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
        Schema::table('project_users', function (Blueprint $table) {
            if (!Schema::hasColumn('project_users', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('project_users', 'project_id')) {
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            }
        });

        Schema::table('time_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('time_entries', 'project_id')) {
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            }
        });

        Schema::table('project_attachments', function (Blueprint $table) {
            if (!Schema::hasColumn('project_attachments', 'project_id')) {
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['project_id']);
        });

        Schema::table('time_entries', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::table('project_attachments', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });
    }
};
