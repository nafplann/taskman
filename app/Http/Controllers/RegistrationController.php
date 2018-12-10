<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\User;

class RegistrationController extends Controller
{
    public function __construct() 
    {
        $this->middleware('guest')->except(['destroy']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
            
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->all()];
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password)
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }

        // Login the new user
        auth()->guard()->login($user);

        // Redirect to home page
        return ['status' => true, 'redirectTo' => '/'];
    }
}
