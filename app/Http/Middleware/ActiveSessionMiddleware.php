<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSeller()) {
            $activeSession = $user->activeSession();
            
            if (!$activeSession) {
                return redirect()->route('seller.session.create')->withErrors(['session' => 'Anda harus memulai sesi jualan terlebih dahulu.']);
            }
        }

        return $next($request);
    }
}
