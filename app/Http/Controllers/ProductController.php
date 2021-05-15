<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Product;

class ProductController extends Controller
{
    public function add(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
        
        ]);

        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }
        
        $p = new Product();        
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->name = $request->name;     
        $p->save();

        $url = "http://localhost:8000/storage/";
        $file = $request->file('image');
        
        if($file){
            $extention = $file->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('proimages', $p->id.'.'.$extention );
            $p->image = $path;
            $p->imgpath = $url.$path;
            $p->save();
        }
        

        return Response::json(['message'=>'Product has been successfully added']);

    }

    public function update(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'id' => 'required',
        
        ]);

        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }
        
        $p =  Product::find($request->id);        
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->name = $request->name;     
        $p->save();

        $url = "http://localhost:8000/storage/";
        $file = $request->file('image');
        
        if($file){

            $p =  Product::find($request->id); 
            Storage::disk('public')->delete($p->image);           
            $p->delete();

            $extention = $file->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('proimages', $p->id.'.'.$extention );
            $p->image = $path;
            $p->imgpath = $url.$path;
            $p->save();
        }

        return Response::json(['message'=>'Product has been successfully update']);
    }

    public function delete(Request $request){
        $validator = Validator::make( $request->all(), [            
            'id' => 'required',        
        ]);        
        if( $validator->fails() ){
            return Response::json(['error'=>$validator->errors()->all()], 409);
        }
        
        $p =  Product::find($request->id); 
        Storage::disk('public')->delete($p->image);           
        $p->delete();
        return Response::json(['message'=>'Product has been successfully deleted']);
    }


    public static function show(Request $request){
        session(['key' => $request->keywords]);
        $products = Product::where(function($q){
            $value = session('key');
            $q->where('products.id', 'LIKE', '%'.$value.'%')
            ->orwhere('products.name', 'LIKE', '%'.$value.'%')
            ->orwhere('products.category', 'LIKE', '%'.$value.'%')
            ->orwhere('products.price', 'LIKE', '%'.$value.'%');
        })->get();

        return Response::json(['products'=>$products]);

    }


}
