<?php

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskStatusStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $taskStatus = $this->route('task_status') ?? new TaskStatus();
        return Auth::check() && $this->user()->can('create', $taskStatus);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:task_statuses,name',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.unique_status'),
        ];
    }
}
