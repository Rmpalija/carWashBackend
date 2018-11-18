<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request) {

        $userId = $request->get('userId');

        $user = User::where('id', '=', $userId)->get();


        if($request->get('password') != null){
            $request['password'] = bcrypt($request->get('password'));
        }else{
            $request['password'] = $user[0]['password'];
        }

        unset($request['userId']);

        $udpateUser = User::where('id', '=', $userId)->update($request->all());

        return response()->json(['status'=>'success','user' => $udpateUser],200);

    }
}
