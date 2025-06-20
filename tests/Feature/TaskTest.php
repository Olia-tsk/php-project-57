<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testIndexDisplaysTasksWithPagination()
    {
        Task::factory()->count(20)->create();
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200)
            ->assertViewIs('tasks.index')
            ->assertViewHas('tasks', function ($tasks) {
                return $tasks->count() === 15;
            });
    }

    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $this->actingAs($this->user);

        $data = [
            'name' => 'Test Task',
            'description' => 'This is a test task description',
            'status_id' => TaskStatus::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];

        $response = $this->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('flash_message', __('app.flash.task.created'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testStoreFailsWithInvalidData()
    {
        $data = ['name' => '', 'status_id' => ''];

        $response = $this->post(route('tasks.store'), $data);

        $response->assertSessionHasErrors(['name', 'status_id']);
        $this->assertDatabaseMissing('tasks', ['created_by_id' => $this->user->id]);
    }

    public function testShowDisplaysTask()
    {
        $task = Task::factory()->create(['name' => 'Test Task']);

        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200)
            ->assertViewIs('tasks.show')
            ->assertViewHas('task', function ($viewTask) use ($task) {
                return $viewTask->id === $task->id;
            });
    }

    public function testEdit()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);

        $task = Task::factory()->create();
        $data = [
            'name' => 'Updated Task Name',
            'description' => 'Updated task description',
            'status_id' => TaskStatus::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];

        $response = $this->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('flash_message', __('app.flash.task.updated'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testUpdateFailsWithInvalidData()
    {
        $task = Task::factory()->create(['name' => 'Old Task']);
        $data = ['name' => '', 'status_id' => ''];

        $response = $this->patch(route('tasks.update', $task), $data);

        $response->assertSessionHasErrors(['name', 'status_id']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Old Task']);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create([
            'name' => 'Test Task',
            'created_by_id' => $this->user->id,
        ]);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHas('flash_message', __('app.flash.task.deleted'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testDestroyFailsForNonCreator()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->id]);

        $this->actingAs($this->user);
        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
