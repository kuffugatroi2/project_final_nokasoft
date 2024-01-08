<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function show()
    {
        return view('admin.login.login');
    }

    public function login(LoginRequest $request)
    {
        $input = $request->only(['email', 'password']);
        $data = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->with('error', 'Email hoặc Password sai!');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate(); // Vô hiệu hóa phiên hiện tại
        $request->session()->regenerateToken(); // tái sinh token phiên mới
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return "Chưa làm chức năng quên mật khẩu";
    }
}
