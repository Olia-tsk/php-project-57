<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('created_at', 'asc')->get();
        $taskStatusModel = new TaskStatus();
        return view('statuses.index', compact('taskStatuses', 'taskStatusModel'));
    }

    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('statuses.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses',
        ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        Session::flash('flash_message', __('app.flash.status.created'));

        return redirect()->route('task_statuses.index');
    }

    public function show(TaskStatus $taskStatus)
    {
        //
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('statuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses',
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();

        Session::flash('flash_message', __('app.flash.status.updated'));

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            Session::flash('flash_message_error', __('app.flash.status.deleteFailed'));
            return redirect()->route('task_statuses.index');
        }

        $taskStatus->delete();
        Session::flash('flash_message', __('app.flash.status.deleted'));
        return redirect()->route('task_statuses.index');
    }
}
