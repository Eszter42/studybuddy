<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTaskFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_filter_tasks_by_status(): void
    {
        $user = User::factory()->create();

        Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'todo',
            'title' => 'Task A',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'done',
            'title' => 'Task B',
        ]);

        $this->actingAs($user)
            ->get('/tasks?status=done')
            ->assertSee('Task B')
            ->assertDontSee('Task A');
    }
}