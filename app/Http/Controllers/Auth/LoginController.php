<?php

namespace App\Http\Controllers\Auth;

use App\Models\allUsersModel; // Ensure this matches your model name
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the default login functionality to use the `allusers` table.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'phone' => 'required',
        ]);

        // Attempt to find the user in the `allusers` table
        $user = allUsersModel::where(['phone'=> $request->phone, 'userType' => 'user'])->first();

        // Check if user exists and the password matches
        if ($user) {
            // Log the user in
            Auth::guard('web')->login($user);

            // Redirect to the intended page or home
            return redirect()->route('home')
                ->with('success', 'Logged in successfully.');
        }

        // If authentication fails, redirect back with an error
        return back()->with('error' , 'Wrong Phone Number');
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
