<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;
use App\Mail\SampleMail;
use \App\Models\Roles;

class UserController extends Controller
{
    /**
     * Used to authenticate used
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Used to show user list
     *
     * @return void
     */
    function index()
    {
        if (Auth::user()->is_admin == 1) {
            $data = User::join('roles', 'roles.id', '=', 'users.is_admin')->withTrashed()->orderBy('id', 'desc')->get(['users.*', 'roles.role', 'roles.name as role_name']);
        } else {
            $data = User::join('roles', 'roles.id', '=', 'users.is_admin')->where('is_admin', '!=',1)->orderBy('id', 'desc')->get(['users.*', 'roles.role', 'roles.name as role_name']);
        }

        return view('user.user', compact('data'));
    }

    /**
     * Used to show user registration form
     *
     * @return void
     */
    function registrationForm()
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $url = url('createuser');
        $title = "Create user";
        $roles = Roles::where('role', '!=',1)->get();

        $data = compact('url', 'title', 'roles');

        return view('user.userForm')->with($data);
    }

    /**
     * Used to create user
     *
     * @param Request $request
     * @return void
     */
    function createUser(Request $request)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'required|min:6',
            'role' => 'required'
        ],
        [
            'password' => 'The password field must match confirm password.'
        ]);

        $data = $request->all();
        if (!($data['role'] == 2 || $data['role'] == 3)) {
            $data['role'] = 3;
        }

        User::create([
            'name'  =>  $data['firstname'] . " ". $data['lastname'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['role']
        ]);
        // Mail variable content created 
        $content = [
            'subject' => 'User created',
            'body' => 'You email-id is successfully registered in Data Mangement portal. Your Login credientails are:',
            'email' => 'Email: ' . $data['email'] ,
            'pass' => 'Password:' . $data['password'],
            'titles' => 'Data Management'
        ];

        // send Mail
        Mail::to($data['email'])->send(new SampleMail($content));

        return redirect('createuser')->with('success', 'Registration Completed, now user can login.');
    }

    /**
     * Used to get user data from updation
     *
     * @param [type] $id
     * @return void
     */
    function updateUser($id)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $user = User::find($id);
        if (is_null($user)) {
            return redirect('users');
        } else {
            if ($user->is_admin == 1 && (Auth::user()->is_admin == 2)) {
                return redirect('users');
            }
            $isNotAdmin = true;
            $title = "Update user";
            $url = url('update') . '/' . $id;
            if (Auth::user()->is_admin == 1) {
                $isNotAdmin = false;
            }
            $roles = Roles::where('role', '!=',1)->get();

            $data = compact('user', 'url', 'title', 'isNotAdmin', 'roles');

            return view('user.userForm')->with($data);
        }
    }

    /**
     * Used to update user data
     *
     * @param [int] $id
     * @param Request $request
     * @return void
     */
    function update($id, Request $request)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'required|min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'required|min:6',
        ],
        [
            'password' => 'The password field must match confirm password.'
        ]);
        if (Auth::user()->is_admin != 1 && $request['role'] != 1) {
            $request->validate([
                'role' => 'required'
            ]);
        }

        $user = User::find($id);
        $user->name = $request['firstname'] . ' ' . $request['lastname'];
        $user->password = Hash::make($request['password']);
        if (Auth::user()->is_admin != 1 && $user->is_admin != 1) {
            $user->is_admin = $request['role'];
        }
        $user->save();
        $content = [
            'subject' => 'User created',
            'body' => 'You email-id is successfully registered in Data Mangement portal. Your Login credientails are:',
            'email' => 'Email: ' . $user->email,
            'pass' => 'Password:' . $request['password'],
            'titles' => 'Data Management'
        ];

        Mail::to($user->email)->send(new SampleMail($content));

        return redirect('users')->with('success', 'User updated successfully.');
    }
    /**
     * Used to soft delete user
     *
     * @param [int] $id
     * @return void
     */
    function deleteUser($id)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        return redirect('users')->with('success', 'User soft deleted successfully.');
    }
    /**
     * Used to force delete user
     *
     * @param [int] $id
     * @return void
     */
    function forceDelete($id)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $user = User::withTrashed()->find($id);
        if (!is_null($user)) {
            $user->forceDelete();
        }

        return redirect('users')->with('success', 'User soft deleted successfully.');
    }

    /**
     * Used to restore deleted user 
     *
     * @param [int] $id
     * @return void
     */
    function restore($id)
    {
        if (Auth::user()->is_admin == 3) {
            return redirect('dashboard');
        }
        $user = User::withTrashed()->find($id);
        if (!is_null($user)) {
            $user->restore();
        }

        return redirect('users')->with('success', 'User restored successfully.');
    }
}
