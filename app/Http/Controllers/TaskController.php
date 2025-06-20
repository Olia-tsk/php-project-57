<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('status')->orderBy('id', 'asc')->paginate(15);
        $taskModel = new Task();
        return view('tasks.index', compact('tasks', 'taskModel'));
    }

    public function create()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $task = new Task();
        $users = User::getUsers();
        $statuses = TaskStatus::getStatuses();
        return view('tasks.create', compact('task', 'users', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => '',
            'status_id' => 'required',
            'assigned_to_id' => ''
        ]);
        $data['created_by_id'] = Auth::id();

        $task = new Task();
        $task->fill($data);
        $task->save();

        Session::flash('flash_message', __('app.flash.task.created'));

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::getUsers();
        $statuses = TaskStatus::getStatuses();
        return view('tasks.edit', compact('task', 'statuses', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => '',
            'status_id' => 'required',
            'assigned_to_id' => ''
        ]);

        $task->fill($data);
        $task->save();

        Session::flash('flash_message', __('app.flash.task.updated'));

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        if (!Auth::check() || $task->created_by_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();
        Session::flash('flash_message', __('app.flash.task.deleted'));

        return redirect()->route('tasks.index');
    }
}
