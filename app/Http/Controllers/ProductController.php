<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    
    public function index(){
        
        $record = Product::all();

        return response()->json($record);

    }


    public function create(Request $request){

        $record = new Product;
        $record->name = $request->name;
        $record->description = $request->description;

        $record->save();

        return response()->json(['status' => true, 'message' => 'Record Created']);

    }


    public function update(Request $request, $id)
    // public function update(Request $request)
    {
        try {
            // $record = Product::findOrFail($request->id);
            $record = Product::findOrFail($id);
            $record->name = $request->name;
            $record->description = $request->description;

            $record->save();

            return response()->json(['status' => true, 'message' => 'Succesfully updated']);


        } catch (Exception $e) {
            return response()->json(['status' => false]);
        }
    }

    
    public function delete($id){

        try {
            $record = Product::findOrFail($id);
            $record->delete(); 

            return response()->json(['status' => true, 'message' => 'Succesfully deleted']);
            
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }

    }


}
