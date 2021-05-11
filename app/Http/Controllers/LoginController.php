<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Tttp\Token;
use App\Models\User;



class LoginController extends Controller
{ 
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:user',
            'password' => 'required|string',
            'address' => 'required|string',
            'cellphoneNumber' => 'string',
        ]);

        $user = new user();
        $user->name = $request->input("name");
        $user->lastname = $request->input("lastname");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
        $user->address = $request->input("address");
        $user->cellphoneNumber = $request->input("cellphoneNumber");
        
        
        $user->save();
        


        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }


    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = user::where("email", $request->input("email"))->get()->first();
        if ($user == null) {
            return response()->json([
                "status" => "failure",
                'message' => 'Unauthorized Email'
            ], 401);
        }
        if (!Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "status" => "failure",
                'message' => 'Unauthorized Password'
            ], 401);
        }
        
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}