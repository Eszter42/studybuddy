<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('task_tag') && !Schema::hasTable('tag_task')) {
            Schema::rename('task_tag', 'tag_task');
        }

        if (!Schema::hasTable('tag_task')) {
            Schema::create('tag_task', function (Blueprint $table) {
                $table->foreignId('task_id')->constrained()->cascadeOnDelete();
                $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['task_id', 'tag_id']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tag_task') && !Schema::hasTable('task_tag')) {
            Schema::rename('tag_task', 'task_tag');
        }
    }
};
