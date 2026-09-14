<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $article = $this->route('article');
        $required = $this->isMethod('post') ? 'required' : 'nullable';

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article?->id)],
            'thumbnail' => [$required === 'required' ? 'nullable' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'tags' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'is_pinned' => ['nullable', 'boolean'],
        ];
    }
}
