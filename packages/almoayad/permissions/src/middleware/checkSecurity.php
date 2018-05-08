<?php

namespace Almoayad\Permissions\middleware;

use Almoayad\Permissions\models\permissionsSecurity;
use Almoayad\Permissions\models\permissionsAdmin;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkSecurity
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
            $checkSecurity = permissionsSecurity::first();
            if ($checkSecurity == null) {
                permissionsSecurity::create(['secure_mode' => false, 'created_by' => $user]);
                return redirect('/admins-permissions/create');
            } else {
                if ($checkSecurity->secure_mode == true) {
                    $authorized = permissionsAdmin::where('user_id', $user)
                        ->where('is_active', true)
                        ->exists();
                    if ($authorized == true) {
                        return $next($request);
                    } else {
                        return redirect('/error/no-permission');
                    }
                } elseif ($checkSecurity->secure_mode == false) {
                    $aliasName = explode('.', $request->route()->action['as']);
                    if(end($aliasName) == "create" || end($aliasName) == "store"){
                        return $next($request);
                    }else{
                        return redirect('/admins-permissions/create');
                    }
                }

            }

        }
    }
}
