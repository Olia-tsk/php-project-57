<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusStoreRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Models\TaskStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class TaskStatusController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id', 'asc')->get();
        $taskStatusModel = new TaskStatus();
        return view('statuses.index', compact('taskStatuses', 'taskStatusModel'));
    }

    public function create()
    {
        $this->authorize('create', TaskStatus::class);

        $taskStatus = new TaskStatus();
        return view('statuses.create', compact('taskStatus'));
    }

    public function store(TaskStatusStoreRequest $request)
    {
        $data = $request->validated();

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        Session::flash('success', __('app.flash.status.created'));

        return redirect()->route('task_statuses.index');
    }

    public function show(TaskStatus $taskStatus)
    {
        $this->authorize('view', $taskStatus);
    }

    public function edit(TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);

        return view('statuses.edit', compact('taskStatus'));
    }

    public function update(TaskStatusUpdateRequest $request, TaskStatus $taskStatus)
    {
        $data = $request->validated();

        $taskStatus->update($data);

        Session::flash('success', __('app.flash.status.updated'));

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize('delete', $taskStatus);

        if ($taskStatus->tasks()->exists()) {
            Session::flash('error', __('app.flash.status.deleteFailed'));
            return redirect()->route('task_statuses.index');
        }

        $taskStatus->delete();
        Session::flash('success', __('app.flash.status.deleted'));
        return redirect()->route('task_statuses.index');
    }
}
