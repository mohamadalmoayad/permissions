<?php

namespace Almoayad\Permissions\middleware;

use Almoayad\Permissions\models\usersPermission;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkPrivilege
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
        $user = Auth::id();
        $prefix = $request->route()->action['prefix'];
        $aliasName = explode('.', $request->route()->action['as']);

        if ($prefix == '/') {
            $link = $prefix . $aliasName[0];
        } else {
            $link = $prefix . '/' . $aliasName[0];
        }
        $checkPermission = usersPermission::where('link', $link)
            ->where(end($aliasName), 1)
            ->exists();
        if($checkPermission == true){
            return $next($request);
        }else{
            return redirect('/error/no-permission');
        }

    }
}
