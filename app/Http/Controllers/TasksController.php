<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Models\Images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
       
            $data=Task::with(['user:id,name,email,phone','img:task_id,img_name'])->get();

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
            'user_id'=>Auth::user()->id,
            'address'=>$request->address,
            'type'=>$request->type,
            'size'=>$request->size,
            'bedrooms'=>$request->bedrooms,
            'bathrooms'=>$request->bathrooms,
            'description'=>$request->description,
            'location'=>$request->location,
            'city'=>$request->city,    
        ]);
        if($request->has('image')){
            
                $images = $request->file('image');
                foreach ($images as  $img) {
                    $img_name=time() .$img->getClientOriginalName();
                    $img->move(public_path('images'), $img_name);
                    $img=Images::create([
                        'img_name'=>$img_name,
                        'task_id'=>$task->id,
                    ]);
                

                    
                }
               
            }
       
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
        $data=Task::where('id',$id)->with(['user:id,name,email,phone','img:task_id,img_name'])->get();

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
