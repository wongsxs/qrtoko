<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the application landing page.
     */
    public function index(): View
    {
        $featuredStores = Store::withCount('products')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('featuredStores'));
    }
}
