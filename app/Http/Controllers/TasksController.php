<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return TaskResource::collection(
        //     Task::where('owner_id',Auth::user()->id)->get()   عرض خاص للمالك
        // );
        $data = DB::table('tasks')
            ->select('tasks.id','tasks.address','tasks.type','tasks.size','tasks.bedrooms','tasks.bathrooms','tasks.description','tasks.location','tasks.city','users.name','users.email','users.phone')
            ->join('users', 'tasks.owner_id', '=', 'users.id')
            ->get();
        return response()->json([
           $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        $request->validated($request->all());
        $task =Task::create([
            'owner_id'=>Auth::user()->id,
            'address'=>$request->address,
            'type'=>$request->type,
            'size'=>$request->size,
            'bedrooms'=>$request->bedrooms,
            'bathrooms'=>$request->bathrooms,
            'description'=>$request->description,
            'location'=>$request->location,
            'city'=>$request->city,    


        ]);
        return response()->json([ new TaskResource($task)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('tasks')
        ->select('tasks.id','tasks.address','tasks.type','tasks.size','tasks.bedrooms','tasks.bathrooms','tasks.description','tasks.location','tasks.city','users.name','users.email','users.phone')
        ->join('users', 'tasks.owner_id', '=', 'users.id')
        ->where('tasks.id' , $id)
        ->get();
    return response()->json([
       $data
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            Task::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->owner_id){
            return $this->error('','you are not authorized to make this request',403);
        }
        $task->update($request->all());
        return response()->json([
            new TaskResource($task)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : $task->delete();
    }
    private function isNotAuthorized($task)
    {
        if(Auth::user()->id !== $task->owner_id){
            return $this->error('','you are not authorized to make this request',403);
        }
    }
}
