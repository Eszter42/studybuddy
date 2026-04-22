<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('test1234'),
            ]
        );

        $math = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Mathematics',
            ],
            [
                'teacher' => 'Joe',
                'color' => '#8b5cf6',
            ]
        );

        $english = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'English',
            ],
            [
                'teacher' => 'John',
                'color' => '#3b82f6',
            ]
        );

        $history = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'History',
            ],
            [
                'teacher' => 'Josh',
                'color' => '#f59e0b',
            ]
        );

        $household = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Household',
            ],
            [
                'teacher' => null,
                'color' => '#10b981',
            ]
        );

        Task::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Practice algebra problems',
            ],
            [
                'subject_id' => $math->id,
                'description' => 'Solve exercises from chapter 5',
                'status' => 'todo',
                'priority' => 'high',
                'due_at' => now()->addDays(2),
                'estimate_minutes' => 60,
                'completed_at' => null,
            ]
        );

        Task::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Write an essay',
            ],
            [
                'subject_id' => $english->id,
                'description' => 'Essay about modern literature',
                'status' => 'doing',
                'priority' => 'high',
                'due_at' => now()->addDays(3),
                'estimate_minutes' => 90,
                'completed_at' => null,
            ]
        );

        Task::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Study World War II',
            ],
            [
                'subject_id' => $history->id,
                'description' => 'Review key events and dates',
                'status' => 'todo',
                'priority' => 'medium',
                'due_at' => now()->addDays(5),
                'estimate_minutes' => 75,
                'completed_at' => null,
            ]
        );

        Task::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Clean the room',
            ],
            [
                'subject_id' => $household->id,
                'description' => 'Vacuum and organize desk',
                'status' => 'todo',
                'priority' => 'low',
                'due_at' => now()->addDays(1),
                'estimate_minutes' => 30,
                'completed_at' => null,
            ]
        );

        Task::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Do the laundry',
            ],
            [
                'subject_id' => $household->id,
                'description' => 'Wash and fold clothes',
                'status' => 'done',
                'priority' => 'low',
                'due_at' => now()->subDays(1),
                'estimate_minutes' => 45,
                'completed_at' => now()->subHours(5),
            ]
        );
    }
}