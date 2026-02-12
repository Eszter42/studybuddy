<?php

namespace App\Providers;

use App\Models\{Subject, Task, Subtask, Tag, Attachment};
use App\Policies\{SubjectPolicy, TaskPolicy, SubtaskPolicy, TagPolicy, AttachmentPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Subject::class => SubjectPolicy::class,
        Task::class => TaskPolicy::class,
        Subtask::class => SubtaskPolicy::class,
        Tag::class => TagPolicy::class,
        Attachment::class => AttachmentPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
