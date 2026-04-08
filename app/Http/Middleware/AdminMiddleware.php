<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Nhớ import dòng này
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra xem đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Lấy role và chuyển về chữ thường để so sánh cho chuẩn
        $role = strtolower(trim(Auth::user()->role));

        // 3. Kiểm tra quyền admin
        if ($role === 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, đá về trang chủ với thông báo
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vùng này!');
    }
}