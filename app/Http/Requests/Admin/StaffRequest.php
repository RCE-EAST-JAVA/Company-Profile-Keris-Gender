<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staff = $this->route('staff');
        $required = $this->isMethod('post') ? 'required' : 'nullable';

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('staff', 'slug')->ignore($staff?->id)],
            'role' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['Research Assistant', 'Researcher'])],
            'expertise' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => [$required, 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'email' => ['nullable', 'email', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
