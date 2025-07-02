<?php

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStatusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $taskStatus = $this->route('task_status') ?? new TaskStatus();
        return $this->user()?->can('update', $taskStatus);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('task_statuses')->ignore($this->route('task_status')->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.unique_status'),
        ];
    }
}
