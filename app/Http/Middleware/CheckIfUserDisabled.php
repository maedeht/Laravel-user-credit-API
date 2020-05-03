<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! auth()->user()->isActive())
            return $this->respondError('User is blocked');
        return $next($request);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'status_code' => 403
            ]
        ], 403);
    }
}
