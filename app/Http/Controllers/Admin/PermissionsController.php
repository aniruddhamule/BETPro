<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Permissions"; 
        $general = General::first();
        $data['permissions'] = Permission::latest()->paginate($general->paginate);
        return view('admin.acl.permissions.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:admins,name'
        ]);
        Permission::create($request->only('name'));
        return back()->withSuccess(__('Permission created successfully.'));
    }

    public function edit(Permission $permission)
    {
        $data['page_title'] = "Edit Permissions";
        $data['permission'] = $permission;
        return view('admin.acl.permissions.edit', $data);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);
        $permission->update($request->only('name'));
        return redirect()->route('permissions.index')->withSuccess(__('Permission updated successfully.'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        Session::flash('success', __('Permission deleted successfully.'));
        return true;
    }
}
