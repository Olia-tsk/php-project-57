<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $taskModel = new Task();
        $users = User::getUsers();
        $statuses = TaskStatus::getStatuses();

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id')->ignore(null),
                AllowedFilter::exact('created_by_id')->ignore(null),
                AllowedFilter::exact('assigned_to_id')->ignore(null),
            ])
            ->allowedSorts('id')
            ->defaultSort('id')
            ->paginate(15)
            ->appends(request()->query());

        return view('tasks.index', compact('tasks', 'taskModel', 'users', 'statuses'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $task = new Task();
        $users = User::getUsers();
        $statuses = TaskStatus::getStatuses();
        $labels = Label::getLabels();

        return view('tasks.create', compact('task', 'users', 'statuses', 'labels'));
    }

    public function store(TaskStoreRequest $request)
    {

        $data = $request->validated();

        $task = Auth::user()->tasks()->create($data);

        $task->labels()->sync($data['labels'] ?? []);

        Session::flash('success', __('app.flash.task.created'));

        return to_route('tasks.index');
    }

    public function show(Task $task)
    {
        $task->load('labels');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $task->load('labels');
        $users = User::getUsers();
        $statuses = TaskStatus::getStatuses();
        $labels = Label::getLabels();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        $task->labels()->sync($data['labels'] ?? []);

        Session::flash('success', __('app.flash.task.updated'));

        return to_route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        Session::flash('success', __('app.flash.task.deleted'));

        return to_route('tasks.index');
    }
}
