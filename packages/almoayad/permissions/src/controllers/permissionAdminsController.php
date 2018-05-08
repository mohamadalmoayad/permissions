<?php

namespace Almoayad\Permissions\controllers;

use Almoayad\Permissions\models\permissionsAdmin;
use Almoayad\Permissions\models\permissionsSecurity;
use Almoayad\Permissions\models\usersPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class permissionAdminsController extends Controller
{

    public function index()
    {
        $permissions = usersPermission::all();
        return view('permissions::admins.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();
        return view('permissions::admins.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|unique:PRMSN_permissions_admins',
            'is_active' => 'required',
        ]);

        $user = $request->input('user_id');
        $active = $request->input('is_active');
        if ($active == "true") {
            $active = true;
        } else {
            $active = false;
        }
        $creator = Auth::id();
        $createAdmin = permissionsAdmin::create(['user_id' => $user, 'is_active' => $active, 'created_by' => $creator]);
        if (isset($createAdmin->id))
            permissionsSecurity::where('secure_mode', false)->update(['secure_mode' => true, 'created_by' => $user]);
        return redirect()->route('admins-permissions.create');
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

}
