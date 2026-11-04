<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display merchant dashboard with their stores.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $stores = $user->stores()
            ->withCount('products')
            ->latest()
            ->get();

        return view('dashboard', compact('stores', 'user'));
    }
}
