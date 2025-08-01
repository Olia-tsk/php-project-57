<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task') ?? new Task();
        return $this->user() && $this->user()->can('create', $task);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'nullable',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
            'labels' => 'nullable',
        ];
    }
}
