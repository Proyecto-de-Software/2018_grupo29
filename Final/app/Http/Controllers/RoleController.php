<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Configuration;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles_index', ['only' => ['index']]);
        $this->middleware('permission:roles_show',   ['only' => ['show']]);
        $this->middleware('permission:roles_new',   ['only' => ['create', 'store']]);
        $this->middleware('permission:roles_destroy',   ['only' => ['delete', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $title = Configuration::title();

        return view('roles.index',compact('title'))->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $title = Configuration::title();

        return view('roles.create',compact('title'))->with('permissions',$permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->description = $request->description;

        $role->save();
        if ($request->permission != NULL)
            $role->attachPermissions($request->permission);
        
        flash('El rol '. $role->name .' ha sido agregado exitosamente')->success();

        return redirect()->route('roles.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->perms;
        $other_permissions = $role->permissionsRoleDoNotOwn();
        $title = Configuration::title();

        return view('roles.show',compact('title'))->with('role', $role)->with('permissions', $permissions)->with('other_permissions', $other_permissions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $title = Configuration::title();

        return view('roles.edit',compact('title'))->with('role',$role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        flash('El rol ' . $role->name .' ha sido actualizado correctamente')->success();

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        flash('El rol ' . $role->name . ' ha sido eliminado')->warning();

        return redirect()->route('roles.index');
    }

    # Refactorizar estos últimos dos métodos
    public function removePermission($role_id, $permission_id) {
        $role = Role::findOrFail($role_id);
        $permission = Permission::findOrFail($permission_id);
        $role->perms()->detach($permission);

        return redirect()->route('roles.show',[$role_id]);
    }

    public function addPermission($role_id, $permission_id) {
        $role = Role::findOrFail($role_id);
        $permission = Permission::findOrFail($permission_id);
        $role->perms()->attach($permission);

        return redirect()->route('roles.show',[$role_id]);
    }
}
