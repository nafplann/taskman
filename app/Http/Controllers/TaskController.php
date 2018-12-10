<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Task;
use App\Project;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'type' => 'required|in:todo,doing,testing,done',
        ]);
            
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->all()];
        }

        try {
            $data = Task::create([
                'content' => $request->content,
                'type' => $request->type,
                'project_id' => $request->id
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }

        return ['status' => true, 'message' => 'Task has been added successfully', 'data' => $data];
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $project = Project::findOrFail($request->id);
        return $project->tasks->where('type', $request->type)
            ->values();
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
