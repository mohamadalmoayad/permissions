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
        $permissions = usersPermission::all();
        return view('permissions::permissions.index', ['permissions' => $permissions]);
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
    }

    public function show($id)
    {
        return $id;
    }

    public function edit($id)
    {
        return 'edit';
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function checkAge()
    {

    }

    protected function getUserPermissions(Request $request)
    {
        $user = $request->input('user');
        $linkArr = [];
        $prefixArr = [];
        $indexArr = [];
        $createArr = [];
        $showArr = [];
        $editArr = [];
        $destroyArr = [];
        $routes = Route::getRoutes();
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
                if (!in_array($link, $linkArr))
                    array_push($linkArr, $link);
            }
        }

        foreach ($linkArr as $link) {
            $checkLinkPrefix = routesPrefix::select('prefix')->where('link', $link)->first();
            if ($checkLinkPrefix == null) {
                array_push($prefixArr, "no prefix has been set");
            } else {
                array_push($prefixArr, $checkLinkPrefix->prefix);
            }
            $permission = usersPermission::where('user_id', $user)
                ->where('link', $link)
                ->first();
            if ($permission == null) {
                array_push($indexArr, 0);
                array_push($createArr, 0);
                array_push($editArr, 0);
                array_push($showArr, 0);
                array_push($destroyArr, 0);
            } else {
                if ($permission->index == 1) {
                    array_push($indexArr, 1);
                } else {
                    array_push($indexArr, 0);
                }
                if ($permission->create == 1) {
                    array_push($createArr, 1);
                } else {
                    array_push($createArr, 0);
                }
                if ($permission->edit == 1) {
                    array_push($editArr, 1);
                } else {
                    array_push($editArr, 0);
                }
                if ($permission->show == 1) {
                    array_push($showArr, 1);
                } else {
                    array_push($showArr, 0);
                }
                if ($permission->destroy == 1) {
                    array_push($destroyArr, 1);
                } else {
                    array_push($destroyArr, 0);
                }
            }
        }
        return view('permissions::permissions.create', ['links' => $linkArr, 'prefixes' => $prefixArr, 'user' => $user, 'indexes' => $indexArr,
            'creates' => $createArr, 'edits' => $editArr, 'shows' => $showArr, 'destroys' => $destroyArr]);
    }

    public function showNoPermission(){
        return view('permissions::error.404');
    }
}
