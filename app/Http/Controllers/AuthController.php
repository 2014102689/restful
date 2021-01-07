<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function __construc(){

        $this->middleware('auth:api',['except' => ['login','register']]);
    
    }

    public function changepass(Request $request)
    {
        try {
            // $record = Product::findOrFail($request->id);
            $record = User::findOrFail($request->id);
            if(password_verify($request->oldpass, $record->password)){
                if($request->newpass == $request->repass){
                    $record->password = Hash::make($request->newpass);
                    $record->save();
                    return response()->json(['status' => true, 'message' => 'Succesfully updated.']);
                }else{
                    return response()->json(['status' => true, 'message' => 'Password not matched.']);
                }
            }else{
                return response()->json(['status' => true, 'message' => 'Your password is incorrect.']);
            }

        } catch (Exception $e) {
            return response()->json(['status' => false]);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if ($token = auth('api')->attempt($credentials)) {
            $userInfo=auth('api')->user();
            // return $this->respondWithToken($token);
            return response()->json(['token' => $token , 'id' => $userInfo->id]);
        }

        return response()->json(['status' => false,'error' => 'Invalid username or password']);
    }


    public function register(Request $request)
    {
        
        $record = new User;
        $record->name = $request->name;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);

        $record->save();

        return response()->json(['status' => true, 'message' => 'User created']);

    }


    public function guard(){
        return \Auth::guard('api');
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }


}
