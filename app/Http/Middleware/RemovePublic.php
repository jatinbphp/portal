<?php

namespace App\Http\Middleware;

use Closure;

class RemovePublic
{
    public function handle($request, Closure $next)
    {
        $url = $request->url();

        // Check if the URL contains 'public' and remove it
        if (strpos($url, 'public') !== false) {
            $newUrl = str_replace('/public', '', $url);
            return redirect($newUrl);
        }

        return $next($request);
    }
}