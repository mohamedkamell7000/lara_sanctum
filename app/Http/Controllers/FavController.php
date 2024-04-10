<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavStoreRequest;
use App\Models\Fav;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class FavController extends Controller
{
    

    public function index()
    {
        $favv= Fav::select('task_id')->where('user_id',Auth::user()->id )->get();
       
        // $data=Fav::where('user_id',Auth::user()->id)->with(['task','owner:id,name,phone,email','img:img_name'])->get();
        $data=Task::with(['user:id,name,email,phone','img:task_id,img_name'])->whereIn('id',$favv )->get();   
        return response()->json([
          $data
        ]);
    }
    
    public function store(FavStoreRequest $request)
    {
        $request->validated($request->all());
        $fav =Fav::create([
            'user_id'=>Auth::user()->id,
            'task_id'=>$request->task_id, 
        ]);
        return response()->json([
            $message ="fav added successfuly",
             $code =200,
             $fav,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    


     public function destroy(Fav $fav)
     {
         return $this->isNotAuthorized($fav) ? $this->isNotAuthorized($fav) : $fav->delete();
     }
     private function isNotAuthorized($fav)
     {
         if(Auth::user()->id !== $fav->user_id){
             return $this->error('','you are not authorized to make this request',403);
         }
     }
}
