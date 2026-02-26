<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiSubjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_subject(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('subjects.store'), [
                'name' => 'Math',
                'teacher' => 'Test Teacher',
                'color' => '#6366f1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('subjects', [
            'name' => 'Math',
            'teacher' => 'Test Teacher',
        ]);
    }
}