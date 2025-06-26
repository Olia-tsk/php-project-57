<?php

namespace App\Http\Requests;

use App\Models\Label;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LabelStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $label = $this->route('label') ?? new Label();
        return Auth::check() && $this->user()->can('create', $label);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:labels',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Метка с таким именем уже существует',
        ];
    }
}
