<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Used to show login page
     */
    function index()
    {
        if(!Auth::check()){
            return view('login');
        }
        return Redirect('dashboard');
    }

    /**
     * Used to check user login
     *
     * @param Request $request
     */
    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            return Redirect('dashboard');
        }

        return redirect('/')->with('fail', 'Login details are not valid');
    }

    /**
     * Used for logout user
     */
    function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('/');
    }
}
