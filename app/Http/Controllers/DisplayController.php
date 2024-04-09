<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DisplayController extends Controller
{
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

   

  
    public function show($id)
    {
        $data=Task::where('id',$id)->with(['user:id,name,email,phone','img:task_id,img_name'])->get();

        return response()->json([
          $data
        ]);
    }


    

    

   
    
}
