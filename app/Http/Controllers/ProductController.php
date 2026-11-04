<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request, Store $store): RedirectResponse
    {
        $this->authorizeStore($store);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $store->products()->create($validated);

        return redirect()
            ->route('stores.edit', $store->slug)
            ->with('success', 'Produk "'.$validated['name'].'" berhasil ditambahkan!');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Store $store, Product $product): RedirectResponse
    {
        $this->authorizeStore($store);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('stores.edit', $store->slug)
            ->with('success', 'Produk "'.$product->name.'" berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Store $store, Product $product): RedirectResponse
    {
        $this->authorizeStore($store);

        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $name = $product->name;
        $product->delete();

        return redirect()
            ->route('stores.edit', $store->slug)
            ->with('success', 'Produk "'.$name.'" telah dihapus.');
    }

    /**
     * Verify that the current user owns this store.
     */
    protected function authorizeStore(Store $store): void
    {
        if ($store->user_id && $store->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengelola produk toko ini.');
        }
    }
}
