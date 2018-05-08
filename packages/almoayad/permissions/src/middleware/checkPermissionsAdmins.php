<?php

namespace Almoayad\Permissions\middleware;

use Almoayad\Permissions\models\permissionsAdmin;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkPermissionsAdmins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::id();
        if ($user == null) {
            return redirect('/login');
        } else {
            $authorized = permissionsAdmin::where('user_id', $user)
                ->where('is_active', true)
                ->exists();
            if ($authorized == true) {
                return $next($request);
            } else {
                return redirect('/error/no-permission');
            }
        }
    }
}
