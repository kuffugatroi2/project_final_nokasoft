<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{
    public function show()
    {
        return view('admin.login.login');
    }

    public function forgotPassword()
    {
        return "Chưa làm chức năng quên mật khẩu";
    }
}
