<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users_index', ['only' => ['index']]);
        $this->middleware('permission:users_new',   ['only' => ['create', 'store']]);
        $this->middleware('permission:users_destroy',   ['only' => ['delete', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::active($request->is_active)->username($request->username)->where('id', '<>', Auth::user()->id)->paginate(3);

        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $user = new User;
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->is_active = true;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        $user->save();
        flash('El registro de ' . $user->first_name . ' ' . $user->last_name . ' ha sido exitoso')->success();

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40'
        ]);

        $user = User::findOrFail($user->id);
        $user->update($request->all());
        flash('Los datos de ' . $user->first_name . ' ' . $user->last_name . ' han sido actualizados exitosamente')->success();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash($user->first_name . ' ' . $user->last_name . ' ha sido eliminado/a')->warning();

        return redirect()->route('users.index');
    }

    public function block($id) {
        return $this->blocking($id, 0);
    }

    public function unblock($id) {
        return $this->blocking($id, 1);
    }

    protected function blocking($id, $newStatus) {
        $user = User::findOrFail($id);
        $user->is_active = $newStatus;
        $user->save();

        return redirect()->route('users.index');
    }

    public function roles($id) {
        $user = User::findOrFail($id);
        $roles = $user->roles;
        $otherRoles = $user->rolesUserDoNotOwn();

        return view('users.roles')->with('user', $user)->with('roles', $roles)->with('otherRoles', $otherRoles);
    }

    # Refactorizar estos últimos dos métodos
    public function addRole($user_id, $role_id){
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($role_id);
        $user->roles()->attach($role);

        return redirect()->route('users.roles',[$user_id]);
    }

    public function removeRole($user_id, $role_id){
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($role_id);
        $user->roles()->detach($role);

        return redirect()->route('users.roles',[$user_id]);
    }
}
