<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::user()->role == 'Pelanggan') {
            return redirect()->intended(route('pilihmenu'));
        }elseif (in_array(Auth::user()->role, ['Kasir', 'Kitchen', 'Owner'])) {
            return redirect()->intended(route('dashboard'));
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        Auth::logout();
        Alert::success('Berhasil', 'Anda Berhasil Logout');
        return redirect('/');
    }
}
