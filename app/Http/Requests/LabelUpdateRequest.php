<?php

namespace App\Http\Requests;

use App\Models\Label;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LabelUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $label = $this->route('label') ?? new Label();
        return $this->user() && $this->user()->can('update', $label);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('labels')->ignore($this->route('label')->id),
            ],
            'description' => 'nullable',
        ];
    }
}
