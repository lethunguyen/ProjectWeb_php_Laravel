<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Giả lập: kiểm tra session role = admin/superadmin
        if (!session()->has('admin_role')) {
            return redirect('/')->with('error','Bạn không có quyền truy cập admin.');
        }
        return $next($request);
    }
}
