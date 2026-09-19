<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageOptimizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorUploadController extends Controller
{
    public function store(Request $request, ImageOptimizer $imageOptimizer): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $path = $imageOptimizer->optimizeAndStore($request->file('image'), 'editor', 1600, 85);

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }
}
