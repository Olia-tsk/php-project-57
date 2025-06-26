<?php

namespace Tests\Feature;

use App\Http\Requests\LabelStoreRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
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
        Label::factory()->count(3)->create();

        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
        $response->assertViewHas('labels', fn($labels) => $labels->count() === 3);
        $response->assertViewHas('labelModel', fn($labelModel) => $labelModel instanceof Label);
    }

    public function testCreateIsRestrictedForUnauthenticatedUser()
    {
        $response = $this->get(route('labels.create'));

        $response->assertStatus(403);
    }

    public function testCreateDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('labels.create'));

        $response->assertStatus(200);
        $response->assertViewIs('labels.create');
        $response->assertViewHas('label', fn($label) => $label instanceof Label);
    }

    public function testStoreForAuthenticatedUser()
    {
        $this->actingAs($this->user);

        $data = ['name' => 'Test Label', 'description' => 'Test Description'];

        $this->mock(LabelStoreRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('flash_message', __('app.flash.label.created'));
        $this->assertDatabaseHas('labels', ['name' => 'Test Label']);
    }

    public function testStoreFailsForUnauthenticatedUser()
    {
        $response = $this->post(route('labels.store'), ['name' => 'Test Label']);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', ['name' => 'Test Label']);
    }

    public function testShowIsRestricted()
    {
        $label = Label::factory()->create();

        $response = $this->get(route('labels.show', $label));

        $response->assertStatus(403);
    }

    public function testEditIsRestrictedForUnauthenticatedUser()
    {
        $label = Label::factory()->create();

        $response = $this->get(route('labels.edit', $label));

        $response->assertStatus(403);
    }

    public function testEditDisplaysFormForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $label = Label::factory()->create();

        $response = $this->get(route('labels.edit', $label));

        $response->assertStatus(200);
        $response->assertViewIs('labels.edit');
        $response->assertViewHas('label', fn($viewLabel) => $viewLabel->is($label));
    }

    public function testUpdateForAuthenticatedUser()
    {
        $this->actingAs($this->user);
        $label = Label::factory()->create();
        $data = ['name' => 'Updated Label', 'description' => 'Updated Description'];

        $this->mock(LabelUpdateRequest::class, fn($mock) => $mock->shouldReceive('validated')->andReturn($data));

        $response = $this->put(route('labels.update', $label), $data);

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('flash_message', __('app.flash.label.updated'));
        $this->assertDatabaseHas('labels', ['id' => $label->getKey(), 'name' => 'Updated Label']);
    }

    public function testUpdateFailsForUnauthenticatedUser()
    {
        $label = Label::factory()->create();
        $data = ['name' => 'Updated Label'];

        $response = $this->put(route('labels.update', $label), $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('labels', ['id' => $label->getKey(), 'name' => 'Updated Label']);
    }

    public function testDestroyDeletesLabelWithoutTasks()
    {
        $this->actingAs($this->user);
        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('flash_message', __('app.flash.label.deleted'));
        $this->assertDatabaseMissing('labels', ['id' => $label->getKey()]);
    }

    public function testDestroyFailsForLabelWithTasks()
    {
        $this->actingAs($this->user);
        $label = Label::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->labels()->attach($label->getKey());

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('flash_message_error', __('app.flash.label.deleteFailed'));
        $this->assertDatabaseHas('labels', ['id' => $label->getKey()]);
    }

    public function testDestroyFailsForUnauthenticatedUser()
    {
        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));

        $response->assertStatus(403);
        $this->assertDatabaseHas('labels', ['id' => $label->getKey()]);
    }
}
