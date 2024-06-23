<?php

namespace App\Http\Controllers\Backend;


use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::get();
        return view('backend.pages.permission.all_permission',compact('permissions'));
    }

    public function AddPermission ()
    {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request)
    {
        Permission::insert([
            'name' =>$request->name,
            'group_name' =>$request->group_name
        ]);

        $notification = array(
            'message' =>"Permission Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/permission')->with($notification);
    }

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));
    }

    public function UpdatePermission(Request $request)
    {
       
       $pid = $request->id;
       Permission::findOrFail($pid)->update([
            'name' =>$request->name,
            'group_name' =>$request->group_name
        ]);

        $notification = array(
            'message' =>"Permission Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/permission')->with($notification);
    }


    public function DeletePermission ($id)
    {
        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' =>"Permission Delete Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/permission')->with($notification);

    }

    public function ImportPermission()
    {
        return view('backend.pages.permission.import_permission');
    }
    public function Export(Request $request)
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' =>"Permission Import Successfully!",
            'alert-type' =>'success'
        );
        return redirect('/all/permission')->with($notification);
    }


    // <!-------------------------Permission Section End Here           -------------------->

    public function AllRoles()
    {
        $roles = Role::get();
        return view('backend.pages.roles.all_roles',compact('roles'));
    }

    public function AddRoles()
    {
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request)
    {
        Role::insert([
            'name' =>$request->name,
          
        ]);

        $notification = array(
            'message' =>"Role Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/roles')->with($notification);
    }

    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles',compact('roles'));
    }

    public function UpdateRoles(Request $request)
    {
       
       $pid = $request->id;
       Role::findOrFail($pid)->update([
            'name' =>$request->name,
        ]);

        $notification = array(
            'message' =>"Role Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/roles')->with($notification);
    }


    public function DeleteRoles ($id)
    {
        Role::findOrFail($id)->delete();

        $notification = array(
            'message' =>"Role Delete Successfully!",
            'alert-type' =>'success'
        );

      return redirect('/all/roles')->with($notification);

    }

    public function AddRolesPermission()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission',compact('roles','permissions','permission_groups'));
    }

    public function RolePermissionStore(Request $request)
    {
        $data = array();
        $permissions = $request->permission;

        foreach($permissions as $key => $item){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' =>"Role And Permission Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function AllRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::get();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.all_roles_permission',compact('roles','permissions','permission_groups'));
    }

    public function AdminEditRoles($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission',compact('role','permissions','permission_groups'));
    }

    public function AdminRolesUpdate(Request $request,$id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }
        $notification = array(
            'message' =>"Role And Permission Update Successfully!",
            'alert-type' =>'success'
        );

      return redirect('all/roles/permission')->with($notification);
    }

    public function AdminDeleteRoles($id)
    {
        $role = Role::findOrFail($id);

        if(!is_null($role)){
            $role->delete();
        }

        $notification = array(
            'message' =>"Role And Permission Delete Successfully!",
            'alert-type' =>'success'
        );

      return redirect('all/roles/permission')->with($notification);
    }

}
