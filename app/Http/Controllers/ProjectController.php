<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendInvitationEmail;

use App\Project;
use App\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->projects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Show the form for invite a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite()
    {
        return view('projects.invite');
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
            'description' => 'required'
        ]);
            
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->all()];
        }

        try {
            $data = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => auth()->user()->id
            ]);
            
            // Add user to the project member
            $data->users()->attach(auth()->user()->id);
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }

        return ['status' => true, 'message' => 'Project has been added successfully', 'data' => $data];
    }

    /**
     * Send invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendInvitation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
            
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->all()];
        }

        $project = Project::findOrFail($request->id);
        $isRegistered = User::where('email', $request->email)
            ->first();
        
        if ($isRegistered) {
            $alreadyInProject = $project->users->contains($isRegistered->id);
            
            if (! $alreadyInProject) {
                $project->users()->attach($isRegistered->id);
                return ['status' => true, 'message' => 'User has been added successfully'];
            }

            return ['status' => true, 'message' => 'User already in project'];
        }

        Mail::to($request->email)->send(new SendInvitationEmail($project));

        return ['status' => true, 'message' => 'Invitation sent'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $allowed = $project->users->contains(auth()->user()->id);
        
        if (! $allowed) abort(404);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
