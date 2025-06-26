<?php

namespace Tests\Feature;

use App\Http\Requests\TaskStatusStoreRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        TaskStatus::factory()->count(3)->create();

        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('statuses.index');
        $response->assertViewHas('taskStatuses', fn($taskStatuses) => $taskStatuses->count() === 3);
        $response->assertViewHas('taskStatusModel', fn($taskStatusModel) => $taskStatusModel instanceof TaskStatus);
    }

    public function testCreateIsRestrictedForUnauthenticatedUser()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(403);
    }

    public function testCreateDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('statuses.create');
        $response->assertViewHas('taskStatus', fn($taskStatus) => $taskStatus instanceof TaskStatus);
    }

    public function testStoreForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $data = ['name' => 'Test Status'];

        $this->mock(TaskStatusStoreRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->post(route('task_statuses.store'), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_message', __('app.flash.status.created'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Test Status']);
    }

    public function testStoreFailsForUnauthenticatedUser()
    {
        $response = $this->post(route('task_statuses.store'), ['name' => 'Test Status']);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', ['name' => 'Test Status']);
    }

    public function testShowIsRestricted()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.show', $taskStatus));

        $response->assertStatus(403);
    }

    public function testEditIsRestrictedForUnauthenticatedUser()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $taskStatus));

        $response->assertStatus(403);
    }

    public function testEditDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $taskStatus));

        $response->assertStatus(200);
        $response->assertViewIs('statuses.edit');
        $response->assertViewHas('taskStatus', fn($viewTaskStatus) => $viewTaskStatus->is($taskStatus));
    }

    public function testUpdateForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $taskStatus = TaskStatus::factory()->create();
        $data = ['name' => 'Updated Status'];

        $this->mock(TaskStatusUpdateRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->put(route('task_statuses.update', $taskStatus), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_message', __('app.flash.status.updated'));
        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->getKey(), 'name' => 'Updated Status']);
    }

    public function testUpdateFailsForUnauthenticatedUser()
    {
        $taskStatus = TaskStatus::factory()->create();
        $data = ['name' => 'Updated Status'];

        $response = $this->put(route('task_statuses.update', $taskStatus), $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->getKey(), 'name' => 'Updated Status']);
    }

    public function testDestroyDeletesStatusWithoutTasks()
    {
        $this->actingAs($this->user);
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_message', __('app.flash.status.deleted'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->getKey()]);
    }

    public function testDestroyFailsForStatusWithTasks()
    {
        $this->actingAs($this->user);
        $taskStatus = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $taskStatus->getKey()]);

        $response = $this->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_message_error', __('app.flash.status.deleteFailed'));
        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->getKey()]);
    }

    public function testDestroyFailsForUnauthenticatedUser()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->getKey()]);
    }
}
