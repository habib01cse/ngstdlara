<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\User;

class userController extends Controller
{

    public static function register(Request $request){
        $validator = Validator::make( $request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
            
        ]);

        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = encrypt( $request->password );
        $user->save();
        return Response::json(['message'=>'Register has been successfully!']);

    }


    public static function login(Request $request){
        $validator = Validator::make( $request->all(), [
            'email' => 'required',
            'password' => 'required'
           
        ]);
        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }        
        $user = User::where('email', $request->email)->first();
        
        $password = decrypt($user->password);

        if($user && $password == $request->password){
            return Response::json($user);
        } else{
            return Response::json(['error'=>['oops! Something Going Wrong']], 409);
        }       
        //return Response::json(['message'=>'User has been successfully login!']);

    }




    public static function add(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'mobile' => 'required'
        ]);

        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();
        return Response::json(['message'=>'User successfully added']);

    }

    public static function update(Request $request){
        $validator = Validator::make( $request->all(), [
            'id' => 'required',
            'name' => 'required',
            'mobile' => 'required'
           
        ]);
        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();

        return Response::json(['message'=>'User successfully updated']);

    }

    public static function delete(Request $request){
        $validator = Validator::make( $request->all(), [
            'id'=> 'required'       
           
        ]);
        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }

        try{
            $user = User::where('id', $request->id)->delete();
            return response()->json(['message'=>'User successfully deleted']);
        }catch(Exception $e){
            return Response::json(['error'=>['User cannot be Deleted']], 409);
        }
       

    }


    public static function show(Request $request){
        session(['key' => $request->keywords]);
        $users = User::where(function($q){
            $value = session('key');
            $q->where('users.id', 'LIKE', '%'.$value.'%')
            ->orwhere('users.name', 'LIKE', '%'.$value.'%')
            ->orwhere('users.mobile', 'LIKE', '%'.$value.'%');
        })->get();

        return Response::json(['users'=>$users]);

    }



}
