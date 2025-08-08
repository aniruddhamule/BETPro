<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller{

    function __construct()
    {
         $this->middleware('permission:roles-index|roles-create|roles-edit|roles-destroy', ['only' => ['index','store']],);
         $this->middleware('permission:roles-create', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = "Role Management";
        $general = General::first();
        $data['roles'] = Role::orderBy('id','DESC')->paginate($general->paginate);
        $data['permission'] = Permission::get();
        return view('admin.acl.roles.index',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return back()->with('success','Role created successfully');
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Role";
        $data['role'] = Role::find($id);
        $data['permission'] = Permission::get();
        $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('admin.acl.roles.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        Session::flash('success','Role deleted successfully');
        return true;
    }
}
