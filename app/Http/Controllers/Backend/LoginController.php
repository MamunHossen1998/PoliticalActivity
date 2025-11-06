<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = User::with('roles')->findOrFail(Auth::id());
            $role = $user->roles->firstWhere('is_active', 1) ?? $user->roles->first();
            $segment = $role->route_segment ?? 'admin';
            return redirect('/' . trim($segment, '/') . '/dashboard');
        }
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = User::with('roles')->findOrFail(Auth::id());
            $role = $user->roles->firstWhere('is_active', 1) ?? $user->roles->first();
            $segment = $role->route_segment ?? 'admin';

            session([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role->name ?? null,
                'route_segment' => $segment,
            ]);

            return redirect('/' . trim($segment, '/') . '/dashboard');
        }

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
