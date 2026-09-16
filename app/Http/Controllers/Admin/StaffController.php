<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\Staff;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function __construct(protected ImageOptimizer $imageOptimizer) {}

    public function index()
    {
        $staff = Staff::when(request('search'), function ($q, $s) {
            $q->where('name', 'like', "%{$s}%")
                ->orWhere('role', 'like', "%{$s}%")
                ->orWhere('expertise', 'like', "%{$s}%");
        })
            ->when(request('category'), fn ($q, $c) => $q->where('category', $c))
            ->orderBy('sort_order')->latest()->paginate(12)->withQueryString();

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(StaffRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->imageOptimizer->optimizeAndStore($request->file('image'), 'staff', 1000, 85);

        Staff::create($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(StaffRequest $request, Staff $staff)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->imageOptimizer->deleteOld($staff->getRawOriginal('image'));
            $data['image'] = $this->imageOptimizer->optimizeAndStore($request->file('image'), 'staff', 1000, 85);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        $oldImage = $staff->getRawOriginal('image');
        if ($oldImage && ! str_starts_with($oldImage, 'http')) {
            Storage::disk('public')->delete($oldImage);
        }
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}
