<?php

namespace Almoayad\Permissions\controllers;

use Almoayad\Permissions\models\routesPrefix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

class LinkPrefixesController extends Controller
{

    public function index()
    {
        dd('Test');
    }

    public function create()
    {
        $linksArr = [];
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            if (in_array("App\Http\Middleware\checkPrivilege", $route->action['middleware']) && isset($route->action['as'])){
                $prefix = $route->action['prefix'];
                $aliasName = explode('.', $route->action['as']);
                $aliasName = $aliasName[0];
                if($prefix == '/'){
                    $link = $prefix . $aliasName;
                }else{
                    $link = $prefix . '/' . $aliasName;
                }
                $checkLinkName = routesPrefix::where('link', $link)->exists();
                if($checkLinkName == false && !in_array($link, $linksArr))
                    array_push($linksArr, $link);
            }
        }
        return view('permissions::links-prefixes.create', ['links' => $linksArr]);
    }

    public function store(Request $request)
    {
        $link = $request->input('link');
        $prefix = $request->input('prefix');
        $user = Auth::id();
        $prefixes = routesPrefix::create(['link' => $link, 'prefix' => $prefix, 'created_by' => $user]);
        return redirect()->route('links-prefixes.create');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

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
