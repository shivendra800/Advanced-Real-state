<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AllAgent()
    {
        $allagent = User::where('role', 'agent')->get();
        return view('backend.agentuser.all_agent', compact('allagent'));
    }

    public function AddAgent()
    {
        return view('backend.agentuser.add_agent');
    }

    public function StoreAgent(Request $request)
    {


        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'active',
        ]);

        $notification = array(
            'message' => "Agent Add Successfully!",
            'alert-type' => 'success'
        );

        return redirect('/all/agent')->with($notification);
    }

    public function EditAgent($id)
    {
        $allagent = User::where('role', 'agent')->findOrFail($id);
        return view('backend.agentuser.edit_agent', compact('allagent'));
    }

    public function UpdateAgent(Request $request)
    {

        $pid = $request->id;
        User::findOrFail($pid)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => "Agent Update Successfully!",
            'alert-type' => 'success'
        );

        return redirect('/all/agent')->with($notification);
    }

    public function DeleteAgent($id)
    {
        User::findOrFail($id)->delete();

        $notification = array(
            'message' => "Agent Delete Successfully!",
            'alert-type' => 'success'
        );

        return redirect('/all/agent')->with($notification);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status Change Successfully!']);
    }


    ///    Admin User All Method  --------------------------------------------

    public function AllAdmin()
    {
        $alladmin = User::where('role', 'admin')->get();
        return view('backend.pages.admin.all_admin', compact('alladmin'));
    }

    public function AddAdmin()
    {
        $roles = Role::get();
        return view('backend.pages.admin.add_admin', compact('roles'));
    }

    public function StoreAdmin(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => "New Agent Has Been Add Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }

    public function EditAdmin($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('backend.pages.admin.edit_admin', compact('user', 'roles'));
    }

    public function UpdateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => "New Member Details Has Been Updated  Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }

    public function DeleteAdmin($id)
    {
        $user= User::findOrFail($id);

        if(!is_null($user)){
            $user->delete();
        }

        $notification = array(
            'message' => "New Member  Delete Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }
}
