<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
    }

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' =>"User Logout Successfully!",
            'alert-type' =>'success'
        );

        return redirect('/login')->with($notification);
    }
}
