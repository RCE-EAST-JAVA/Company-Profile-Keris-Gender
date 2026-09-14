<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
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
        $data['image'] = $request->file('image')->store('staff', 'public');

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
            Storage::disk('public')->delete($staff->image);
            $data['image'] = $request->file('image')->store('staff', 'public');
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        Storage::disk('public')->delete($staff->image);
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}
