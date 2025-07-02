<?php

namespace App\Http\Requests;

use App\Models\Label;
use Illuminate\Foundation\Http\FormRequest;

class LabelStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $label = $this->route('label') ?? new Label();
        return $this->user()?->can('create', $label);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:labels,name',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => __('validation.unique_label'),
        ];
    }
}
