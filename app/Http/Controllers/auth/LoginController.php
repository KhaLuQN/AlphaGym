<?php
namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('dashboard.index')
                ->with('success', 'Đăng nhập thành công.');
        }

        return back()->withErrors([
            'errors' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
        ]);

    }
}
