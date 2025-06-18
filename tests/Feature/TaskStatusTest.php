<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testIndexDisplaysTaskStatuses()
    {
        $taskStatuses = TaskStatus::factory()->count(3)->create();

        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('statuses.index');
        $response->assertViewHas('taskStatuses', function ($viewStatuses) use ($taskStatuses) {
            return $viewStatuses->count() === $taskStatuses->count();
        });
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', [$taskStatus]));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = TaskStatus::factory()->make()->only('name');
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_message', __('app.flash.status.created'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testStoreFailsWithInvalidData()
    {
        $response = $this->post(route('task_statuses.store'), ['name' => '']);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('task_statuses', ['name' => '']);
    }

    public function testStoreFailsWithDuplicateName()
    {
        $existingStatus = TaskStatus::factory()->create(['name' => 'Existing Status']);

        $response = $this->post(route('task_statuses.store'), ['name' => 'Existing Status']);

        $response->assertSessionHasErrors('name');
    }

    public function testUpdate()
    {
        $taskStatus = TaskStatus::factory()->create();
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdateFailsWithInvalidData()
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->put(route('task_statuses.update', $taskStatus), ['name' => '']);

        $response->assertSessionHasErrors('name');
    }

    public function testUpdateFailsWithDuplicateName()
    {
        $existingStatus = TaskStatus::factory()->create(['name' => 'Existing Status']);
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->put(route('task_statuses.update', $taskStatus), ['name' => 'Existing Status']);

        $response->assertSessionHasErrors('name');
    }

    public function testDestroy()
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHas('flash_message', __('app.flash.status.deleted'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', $taskStatus->only('id'));
    }
}
