<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if (gs('maintenance_mode') == Status::ENABLE) {
            return to_route('maintenance');
        }
        return $next($request);
    }
}
