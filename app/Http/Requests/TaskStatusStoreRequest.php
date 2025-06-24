<?php

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskStatusStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $taskStatus = $this->route('task_status') ?? new TaskStatus();
        return $this->user() && $this->user()->can('create', $taskStatus);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:task_statuses',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Статус с таким именем уже существует',
        ];
    }
}
