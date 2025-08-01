<?php

namespace Tests\Feature;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
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

    public function testCreateIsRestrictedForUnauthenticatedUser()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(403);
    }

    public function testCreateDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
        $response->assertViewHas('task', fn($task) => $task instanceof Task);
    }

    public function testStoreForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $data = [
            'name' => 'Test Task',
            'status_id' => TaskStatus::factory()->create()->getKey(),
            'created_by_id' => $this->user->id,
        ];

        $this->mock(TaskStoreRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', __('app.flash.task.created'));
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testStoreFailsForUnauthenticatedUser()
    {
        $response = $this->post(route('tasks.store'), ['name' => 'Test Task']);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['name' => 'Test Task']);
    }

    public function testShowDisplaysTask()
    {
        $task = Task::factory()->create(['name' => 'Test Task']);

        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200)
            ->assertViewIs('tasks.show')
            ->assertViewHas('task', function ($viewTask) use ($task) {
                return $viewTask->id === $task->getKey();
            });
    }

    public function testEditIsRestrictedForUnauthenticatedUser()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertStatus(403);
    }

    public function testEditDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.edit');
        $response->assertViewHas('task', fn($viewTask) => $viewTask->is($task));
    }

    public function testUpdateForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create();
        $data = ['name' => 'Updated Task'];

        $this->mock(TaskUpdateRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->put(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', __('app.flash.task.updated'));
        $this->assertDatabaseHas('tasks', ['id' => $task->getKey(), 'name' => 'Updated Task']);
    }

    public function testUpdateFailsForUnauthenticatedUser()
    {
        $task = Task::factory()->create();
        $data = ['name' => 'Updated Task'];

        $response = $this->put(route('tasks.update', $task), $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['id' => $task->getKey(), 'name' => 'Updated Task']);
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
            ->assertSessionHas('success', __('app.flash.task.deleted'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->getKey()]);
    }

    public function testDestroyFailsForUnauthenticatedUser()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->getKey()]);
    }

    public function testDestroyFailsForNonCreator()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->getKey()]);

        $this->actingAs($this->user);
        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->getKey()]);
    }
}
