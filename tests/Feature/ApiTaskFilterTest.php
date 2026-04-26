<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTaskFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_filter_tasks_by_priority(): void
    {
        $user = User::factory()->create();

        Task::factory()->create([
            'user_id' => $user->id,
            'priority' => 'low',
            'title' => 'Task A',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'priority' => 'high',
            'title' => 'Task B',
        ]);

        $this->actingAs($user)
            ->get('/tasks?priority=high')
            ->assertOk()
            ->assertSee('Task B')
            ->assertDontSee('Task A');
    }
}