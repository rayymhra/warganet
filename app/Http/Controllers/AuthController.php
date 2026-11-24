<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function loginForm() { return view('auth.login'); }

    public function login(Request $r) {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (!Auth::attempt($c, $r->boolean('remember')))
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        $r->session()->regenerate();
        return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/resident/dashboard');
    }

    public function registerForm() { return view('auth.register'); }

    public function register(Request $r) {
        $d = $r->validate([
            'name' => 'required|max:100', 'email' => 'required|email|unique:users',
            'phone' => 'nullable|max:20', 'password' => 'required|min:8|confirmed',
        ]);
        // role is never read from input: new accounts are always residents
        $u = User::create(['name' => $d['name'], 'email' => $d['email'], 'password' => Hash::make($d['password'])]);
        $u->forceFill(['role' => 'resident', 'phone' => $d['phone'] ?? null])->save();
        Auth::login($u);
        return redirect('/resident/dashboard');
    }

    public function logout(Request $r) {
        Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken();
        return redirect('/');
    }
}