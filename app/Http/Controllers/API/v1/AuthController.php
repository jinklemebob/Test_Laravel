<?php

namespace App\Http\Controllers\API\v1;


use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    //
public function login (AuthRequest $request){

// Attempt to authenticate the user 

$user = User::where('email', $request->email)->firstOrFail();

try{
if($user) {
    if(! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
$token = $user->createToken('auth_token')->plainTextToken;

return response()->json([
    'access_token' => $token,
    'token_type' => 'Bearer',
]);
    }
catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'An error occurred while generating the token.',
        'error' => $e->getMessage(),
    ], 500);
    
}
}
}
