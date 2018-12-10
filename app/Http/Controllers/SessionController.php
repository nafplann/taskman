<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
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
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if(! auth()->attempt($request->only(['email', 'password']), $request->remember_me ? true : false)) {
            return [
                'status' => false,
                'message' => 'Incorrect email or password'
            ];
        }

        // activity()
        //     ->causedBy(auth()->user())
        //     ->performedOn(auth()->user())
        //     ->log('login');
        
        return [
            'status' => true, 
            'user' => auth()->user(), 
            'redirectTo' => \Session::get('url.intended')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        // activity()
        //     ->causedBy(auth()->user())
        //     ->performedOn(auth()->user())
        //     ->log('logout');

        auth()->logout();

        return redirect('/');
    }
}