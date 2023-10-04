<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        $user = Auth::user(); // 現在のログインユーザーを取得
        $requestedUserId = $request->route('id'); // ルートパラメータからリクエストされたユーザーIDを取得

        // ログインユーザーとリクエストされたユーザーIDが一致しない場合、アクセスを拒否
        if ($user->id != $requestedUserId) {
            return abort(403, 'Access denied');
        }

        return $next($request); // アクセスを許可して次のミドルウェアまたはアクションに進む
    }
}
