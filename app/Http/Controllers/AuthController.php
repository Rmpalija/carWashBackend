<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();

        if(!isset($input['isOwner'])){
            $input['isOwner'] = 0;
        }

        // Hash password
        $input['password'] =  Hash::make($input['password']);

        // Generate code
        $input['code'] = str_random(45);

        $input['displayName'] = $input['firstname'].' '.$input['lastname'];

        User::create($input);

        return response()->json([
            'status' => 'success',
        ],200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('email','=', $credentials['email'])->get();

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user'=> $user
        ],200);
    }

    public function user(Request $request)
    {

            $user = User::find(Auth::user()->id);
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);

    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */

    public function logout(Request $request) {

        $this->validate($request, ['token' => 'required']);
        
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json([
                'status' => 'success',
                'msg' => 'You have successfully logged out.'
            ],200);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to logout, please try again.'
            ],200);
        }
    }
    public function refresh()
    {
      return response()->json([
            'status' => 'success'
        ]);
    }
}
