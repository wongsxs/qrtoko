<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Services\SupabaseStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __construct(
        protected SupabaseStorageService $storageService
    ) {}

    /**
     * Display a listing of registered stores.
     */
    public function index(): View
    {
        $stores = Store::withCount('products')
            ->latest()
            ->paginate(12);

        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     */
    public function create(): View
    {
        return view('stores.create');
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;

            while (Store::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            $data['slug'] = $slug;
        }

        $data['is_open'] = $request->boolean('is_open', true);
        $data['user_id'] = Auth::id();
        $data['facilities'] = $request->input('facilities', []);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storageService->upload($request->file('logo'), 'logos');
        }

        $store = Store::create($data);

        return redirect()
            ->route('stores.edit', $store->slug)
            ->with('success', 'Toko berhasil dibuat! Sekarang kamu bisa menambahkan menu dan mencetak QR Code.');
    }

    /**
     * Display the specified store (Public Mobile View when QR scanned).
     */
    public function show(Store $store): View
    {
        $products = $store->products()
            ->where('is_available', true)
            ->get()
            ->groupBy('category');

        return view('stores.show', compact('store', 'products'));
    }

    /**
     * Show the store management dashboard (Edit info & products).
     */
    public function edit(Store $store): View
    {
        $this->authorizeStore($store);

        $products = $store->products()
            ->latest()
            ->get();

        return view('stores.edit', compact('store', 'products'));
    }

    /**
     * Update the specified store in storage.
     */
    public function update(StoreRequest $request, Store $store): RedirectResponse
    {
        $this->authorizeStore($store);

        $data = $request->validated();
        $data['is_open'] = $request->boolean('is_open');
        $data['facilities'] = $request->input('facilities', []);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                $this->storageService->delete($store->logo);
            }
            $data['logo'] = $this->storageService->upload($request->file('logo'), 'logos');
        }

        $store->update($data);

        return redirect()
            ->route('stores.edit', $store->slug)
            ->with('success', 'Informasi toko berhasil diperbarui!');
    }

    /**
     * Display printable QR Standee / Card for the store.
     */
    public function qr(Store $store): View
    {
        return view('stores.qr', compact('store'));
    }

    /**
     * Remove the specified store from storage.
     */
    public function destroy(Store $store): RedirectResponse
    {
        $this->authorizeStore($store);

        if ($store->logo) {
            $this->storageService->delete($store->logo);
        }

        $store->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Toko berhasil dihapus.');
    }

    /**
     * Verify that the current user owns this store.
     */
    protected function authorizeStore(Store $store): void
    {
        if (! Auth::check() || $store->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengelola toko ini.');
        }
    }
}
