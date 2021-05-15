<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Task;

class taskController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'status' => 'required'
        ]);

        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        $task = new Task();
        $task->name = $request->name;
        $task->status = $request->status;
        $task->save();
        return Response::json(['message'=>'Task successfully added']);

    }

    public static function update(Request $request){
        $validator = Validator::make( $request->all(), [
            'id' => 'required',
            'name' => 'required',
            'status' => 'required'
           
        ]);
        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        $task = Task::find($request->id);
        $task->name = $request->name;
        $task->status = $request->status;
        $task->save();

        return Response::json(['message'=>'Task successfully updated']);

    }

    public static function delete(Request $request){
        $validator = Validator::make( $request->all(), [
            'id'=> 'required'       
           
        ]);
        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        try{
            $task = Task::where('id', $request->id)->delete();
            return response()->json(['message'=>'Task successfully deleted']);
        }catch(Exception $e){
            return Response::json(['error'=>['Task cannot be Deleted']], 409);
        }
       

    }

    public static function view(Request $request){
        session(['key' => $request->keywords]);
        $tasks = Task::all();

        return Response::json(['tasks'=>$tasks]);

    }


    public static function show(Request $request){
        session(['key' => $request->keywords]);
        $tasks = Task::where(function($q){
            $value = session('key');
            $q->where('tasks.id', 'LIKE', '%'.$value.'%')
            ->orwhere('tasks.name', 'LIKE', '%'.$value.'%')
            ->orwhere('tasks.status', 'LIKE', '%'.$value.'%');
        })->get();

        return Response::json(['tasks'=>$tasks]);

    }



}
