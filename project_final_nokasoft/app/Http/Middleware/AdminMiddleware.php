<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        // Nếu không có quyền, chuyển hướng hoặc thực hiện xử lý khác
        return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập trang admin.');
    }
}
