<?php
namespace App\Http\Middleware;
use Closure;
class Cors
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        if ($request->getMethod() === 'OPTIONS') {
            $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
                ->header('Access-Control-Max-Age', '86400');
        }

        if ($response->status() === 500) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ]);
        }

        if ($response->status() === 404) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resource not found'
            ]);
        }

        return $response;
    }

}
