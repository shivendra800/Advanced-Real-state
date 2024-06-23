<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
class AgentController extends Controller
{

    public function AgentLogin()
    {
        return view('agent.agent_login');
    }


    public function AgentRegister(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'agent',
            'status' =>'inactive',

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::AGENT);
    }

    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' =>"Agent Logout Successfully!",
            'alert-type' =>'success'
        );

        return redirect('/agent/login')->with($notification);
    }
    public function AgentDashboard()
    {
        return view('agent.agent_dashboard');
    }
}
