<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Tttp\Token;
use App\Models\User;

class ProfileController extends Controller
{
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:user',
            'password' => 'required|string',
            'address' => 'required|string',
            'cellphoneNumber' => 'string'
        ]);  
        
        try{
            $user = $request->user();
            $user->name = $request->input("name");
            $user->lastname = $request->input("lastname");
            $user->email = $request->input("email");
            $user->password = Hash::make($request->input("password"));
            $user->address = $request->input("address");
            $user->cellphoneNumber = $request->input("cellphoneNumber"); 
            $user->saveUser();

            return response()->json([
                "status" => "success",
                'message' => 'User updated successfully!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
         }
        
    }

    public function deleteUser(Request $request){
        $request->validate([
            'userId' => 'required|integer'
        ]);  

        try{
            $user = $request->user();
            $user = User:: deleteUserById($request->input("userId"));

            return response()->json([
                "status" => "success",
                'message' => 'User deleted successfully!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage()
            ], 500);
         }
        
        
        
    }
}