<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::orderBy('created_at', 'desc')->get();
        return view('statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = new TaskStatus();
        return view('statuses.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $status)
    {
        $status = TaskStatus::findOrFail($status);
        return view('statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $status)
    {
        $data = $request->validated();

        $status->fill($data);
        $status->save();

        Session::flash('flash_message', 'Article successfully updated');

        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $status)
    {
        if ($status) {
            $status->delete();
        }
        return redirect()->route('task_statuses.index');
    }
}
