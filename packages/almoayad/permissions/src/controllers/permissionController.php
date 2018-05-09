<?php

namespace Almoayad\Permissions\controllers;

use Almoayad\Permissions\models\routesPrefix;
use Almoayad\Permissions\models\usersPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class permissionController extends Controller
{

    public function index()
    {
        $users = User::select('id', 'name')->get();
        return view('permissions::permissions.index', ['users' => $users]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();
        return view('permissions::permissions.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $creator = Auth::id();
        $laps = count($request->except('_token', 'user')) / 6;
        for ($i = 1; $i <= $laps; $i++) {
            $user = $request->input('user');
            $link = $request->input('link-' . "$i");
            $index = $request->input('index-' . "$i");
            $create = $request->input('create-' . "$i");
            $store = $create;
            $edit = $request->input('edit-' . "$i");
            $update = $edit;
            $show = $request->input('show-' . "$i");
            $destroy = $request->input('destroy-' . "$i");
            if ($index == 1 || $create == 1 || $edit == 1 || $show == 1 || $destroy == 1)
                $permission = usersPermission::updateOrCreate(['user_id' => $user, 'link' => $link],
                    ['index' => $index, 'create' => $create, 'store' => $store, 'edit' => $edit, 'update' => $update, 'show' => $show, 'destroy' => $destroy, 'created_by' => $creator]);
        }
        return redirect()->route('permissions.index');
    }

    public function show($id)
    {
        $view = 'permissions.show';
        $return = $this->getUserPermissions(Request::create('/get-permissions', 'post', ['user' => $id, 'view' => $view]));
        $permissions = $return['permissions'];
        $user = $return['user'];
        return view('permissions::permissions.show', ['permissions' => $permissions, 'user' => $user]);
    }

    public function edit($id)
    {
        $view = 'permissions.edit';
        $return = $this->getUserPermissions(Request::create('/get-permissions', 'post', ['user' => $id, 'view' => $view]));
        $permissions = $return['permissions'];
        $user = $return['user'];
        return view('permissions::permissions.edit', ['permissions' => $permissions, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        usersPermission::destroy($id);
    }

    public function getUserPermissions(Request $request)
    {
        $user = $request->input('user');
        $links = [];
        $routes = Route::getRoutes();
        $permissions = collect();
        $collector = collect();
        foreach ($routes as $route) {
            if (in_array("Almoayad\Permissions\middleware\checkPrivilege", $route->action['middleware']) && isset($route->action['as'])) {
                $prefix = $route->action['prefix'];
                $aliasName = explode('.', $route->action['as']);
                $aliasName = $aliasName[0];
                if ($prefix == '/') {
                    $link = $prefix . $aliasName;
                } else {
                    $link = $prefix . '/' . $aliasName;
                }
                if (!in_array($link, $links)) {
                    array_push($links, $link);
                }
            }
        }
        foreach ($links as $link) {
            $collector->put('link', $link);
            $checkLinkPrefix = routesPrefix::select('prefix')->where('link', $link)->first();
            if ($checkLinkPrefix == null) {
                $collector->put('prefix', "no prefix has been set");
            } else {
                $collector->put('prefix', $checkLinkPrefix->prefix);
            }
            $permission = usersPermission::where('user_id', $user)
                ->where('link', $link)
                ->first();
            if ($permission == null) {
                $collector->put('id', 0);
                $collector->put('index', 0);
                $collector->put('create', 0);
                $collector->put('edit', 0);
                $collector->put('show', 0);
                $collector->put('destroy', 0);
            } else {
                $collector->put('id', $permission->id);
                if ($permission->index == 1) {
                    $collector->put('index', 1);
                } else {
                    $collector->put('index', 0);
                }
                if ($permission->create == 1) {
                    $collector->put('create', 1);
                } else {
                    $collector->put('create', 0);
                }
                if ($permission->edit == 1) {
                    $collector->put('edit', 1);
                } else {
                    $collector->put('edit', 0);
                }
                if ($permission->show == 1) {
                    $collector->put('show', 1);
                } else {
                    $collector->put('show', 0);
                }
                if ($permission->destroy == 1) {
                    $collector->put('destroy', 1);
                } else {
                    $collector->put('destroy', 0);
                }
            }
                $permissions->push($collector);
            $collector = collect();
        }
        $user = User::select('id', 'name')->where('id', $user)->first();
        $view = $request->input('view');
        return view('permissions::' . "$view", ['permissions' => $permissions, 'user' => $user]);
    }

    public function showNoPermission()
    {
        return view('permissions::error.404');
    }
}
