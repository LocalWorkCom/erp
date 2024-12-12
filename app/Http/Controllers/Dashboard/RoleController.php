<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::with('permissions')->get();
        return view('dashboard.roles.list',compact('roles'));
    }

    public function show($id){
        $roles = Role::with('permissions')->findOrFail($id);

        return view('dashboard.roles.show',compact('role'));

    }
    public function create(){
        $permissions = Permission::where('guard_name','admin')->get();
        return view('dashboard.roles.add',compact('permissions'));

    }
    public function store(){

    }
    public function edit($id){
        $role = Role::with('permissions')->findOrFail($id);

        return view('dashboard.roles.edit',compact('role'));

    }
    public function update(){

    }
    public function delete(){

    }
}
