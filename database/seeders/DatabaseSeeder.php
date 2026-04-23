<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Subtask;
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
            ]
        );

        $english = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'English',
            ],
            [
                'teacher' => 'John',
            ]
        );

        $history = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'History',
            ],
            [
                'teacher' => 'Josh',
            ]
        );

        $household = Subject::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Household',
            ],
            [
                'teacher' => null,
            ]
        );

        $mathTask = Task::updateOrCreate(
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

        $englishTask = Task::updateOrCreate(
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

        $historyTask = Task::updateOrCreate(
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

        $cleanTask = Task::updateOrCreate(
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

        $laundryTask = Task::updateOrCreate(
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

        Subtask::updateOrCreate(
            ['task_id' => $mathTask->id, 'title' => 'Review formulas'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $mathTask->id, 'title' => 'Solve practice problems'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $mathTask->id, 'title' => 'Check answers'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $englishTask->id, 'title' => 'Write outline'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $englishTask->id, 'title' => 'Write first draft'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $englishTask->id, 'title' => 'Proofread final version'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $historyTask->id, 'title' => 'Read textbook chapter'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $historyTask->id, 'title' => 'Take notes on key events'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $historyTask->id, 'title' => 'Memorize important dates'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $cleanTask->id, 'title' => 'Vacuum the floor'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $cleanTask->id, 'title' => 'Organize the desk'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $cleanTask->id, 'title' => 'Take out the trash'],
            ['is_done' => false]
        );

        Subtask::updateOrCreate(
            ['task_id' => $laundryTask->id, 'title' => 'Separate clothes by color'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $laundryTask->id, 'title' => 'Start washing machine'],
            ['is_done' => true]
        );

        Subtask::updateOrCreate(
            ['task_id' => $laundryTask->id, 'title' => 'Fold clean clothes'],
            ['is_done' => true]
        );
    }
}