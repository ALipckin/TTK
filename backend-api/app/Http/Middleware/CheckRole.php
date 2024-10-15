<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();
        // Если пользователь администратор, пропускаем проверку
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        // Проверяем, есть ли у пользователя хотя бы одна из требуемых ролей
        if (!$user || !$user->hasAnyRole($roles)) {
            // Если ни одна из ролей не совпадает, возвращаем ошибку
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
