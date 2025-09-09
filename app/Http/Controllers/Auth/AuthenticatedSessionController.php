<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // Mark that user has visited before for future login messages
        $request->session()->put('has_visited_before', true);
        
        // Clear the fresh logout flag since user is logging back in
        $request->session()->forget('fresh_logout');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        // Clear the visit flag so they get "Welcome" on next login
        $request->session()->forget('has_visited_before');
        
        // Add a flag to indicate fresh logout for security
        $request->session()->put('fresh_logout', true);

        return redirect()->route('login');
    }
}
