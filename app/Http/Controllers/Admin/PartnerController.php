<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function __construct(protected ImageOptimizer $imageOptimizer) {}

    public function index()
    {
        $partners = Partner::when(request('search'), fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()->paginate(12)->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(PartnerRequest $request)
    {
        $data = $request->validated();
        $data['logo'] = $this->imageOptimizer->optimizeAndStore($request->file('logo'), 'partners', 1000, 85);

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $this->imageOptimizer->deleteOld($partner->getRawOriginal('logo'));
            $data['logo'] = $this->imageOptimizer->optimizeAndStore($request->file('logo'), 'partners', 1000, 85);
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $oldLogo = $partner->getRawOriginal('logo');
        if ($oldLogo && ! str_starts_with($oldLogo, 'http')) {
            Storage::disk('public')->delete($oldLogo);
        }
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus.');
    }
}
