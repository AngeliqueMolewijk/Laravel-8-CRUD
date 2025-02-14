<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        return view('login');
    }

    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if (Auth::attempt($user_data)) {
            return redirect('/puzzels');
        } else {
            return back()->with('error', 'Wrong Login Details');
        }
    }

    function successlogin()
    {
        return redirect('puzzels');
        // return view('puzzels.index');

        // return view('successlogin');
    }

    function logout()
    {
        Auth::logout();
        return redirect('/puzzels');
    }
}
