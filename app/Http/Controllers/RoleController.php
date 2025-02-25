<?php

namespace App\Http\Controllers;

use App\Module;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('roles.index');
        $data['roles'] = Role::where('id','!=',2)->get();
        $data['title'] = 'Role';
        return  view('back.role.index',$data);
    }


    public function create()
    {
        Gate::authorize('roles.create');
        $data['modules'] = Module::all();
        $data['title']   = 'Role Create';
        return  view('back.role.create',$data);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'role_name' =>'required',
            'permissions' =>'required|array',
            'permissions.*' =>'integer',
        ]);
        Role::create([
            'name' =>$request->role_name,
            'slug' =>str_slug($request->role_name),
        ])->permissions()->sync($request->input('permissions'),[]);
        session()->flash('success','Role Created Successfully');
        return redirect()->route('roles.index');
    }


    public function show(Role $role)
    {
        //
    }


    public function edit(Role $role)
    {
        Gate::authorize('roles.edit');
        $data['modules'] = Module::all();
        $data['role'] = $role;
        $data['title']   = 'Role Edit';
        return  view('back.role.edit',$data);
    }


    public function update(Request $request, Role $role)
    {
        $this->validate($request,[
            'role_name' =>'required',
            'permissions' =>'required|array',
            'permissions.*' =>'integer',
        ]);
        $role->update([
            'name' => $request->role_name,
            'slug' => str_slug($request->role_name),
        ]);
        $role->permissions()->sync($request->input('permissions'));
        session()->flash('success','Role Update Successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('roles.destroy');
        if ($role->deletable == true){
            $role->delete();
            session()->flash('success','Role Delete Successfully');
            return  redirect()->back();
        }else{
            session()->flash('warning','You can\'t delete system Role');
            return  redirect()->back();
        }
    }
}
