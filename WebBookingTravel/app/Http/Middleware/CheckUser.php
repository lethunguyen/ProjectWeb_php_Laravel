<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user_id')) {
            return redirect('/')->with('error','Vui lòng đăng nhập người dùng.');
        }
        return $next($request);
    }
}
