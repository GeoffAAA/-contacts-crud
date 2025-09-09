<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent ALL caching - even more aggressive
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private, max-age=0, s-maxage=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');

        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // For auth pages, add maximum security (but preserve CSRF tokens)
        if ($request->is('login', 'register', 'password/*')) {
            // Temporarily disable Clear-Site-Data to fix CSRF token issues
            // $response->headers->set('Clear-Site-Data', '"cache", "storage", "executionContexts"');
            $response->headers->set('Surrogate-Control', 'no-store');
            $response->headers->set('Vary', '*');
        }

        return $response;
    }
}
