<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $project = $this->route('project');
        $required = $this->isMethod('post') ? 'required' : 'nullable';

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'image' => [$required, 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'author' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'string', 'max:50'],
            'published_at' => ['nullable', 'date'],
            'is_pinned' => ['nullable', 'boolean'],
        ];
    }
}
