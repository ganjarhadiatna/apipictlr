<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;
 
use App\User;
use App\UserModel;

/**
 * summary
 */
class UserController extends Controller
{
    /**
     * summary
     */

    function login(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);

        $email = $request['email'];
        $password = $request['password'];

        $dt = [
            'email' => $email,
            'password' => $password
        ];

        //return response()->json($dt);

        $user = User::where('email', $email)->first();
        if (!$user) {
            $res = [
                'success' => false,
                'message' => 'Your email incorrect.'
            ];
            return response()->json($res);
        } else {
            if (Hash::check($password, $user->password)) {
                $api_token = sha1(time());//Hash::make(str_random(100));
                $create_token = User::where('id', $user->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $res = [
                        'success' => true,
                        'message' => 'Login success.',
                        'api_token' => $api_token,
                    ];
                    return response()->json($res);
                }
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Your password incorrect.'
                ];
                return response()->json($res);
            }
        }
    }
    function register(Request $request)
    {
        $hasher = app()->make('hash');

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $name = $request['name'];
        $username = $request['username'];
        $email = $request['email'];
        $password = $hasher->make($request['password']);

        $dt = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];

        $register = User::create($dt);
        if ($register) {
            $res = [
                'status' => $register,
                'success' => true,
                'message' => 'Register Success'
            ];
            return response()->json($res);
        } else {
            $res = [
                'status' => $register,
                'success' => false,
                'message' => 'Register Failed'
            ];
            return response()->json($res);
        }

    }
    function getUserById($id)
    {
        $user = User::where('id', $id)->get();
        if ($user) {
            $res = [
                'success' => false,
                'message' => $user
            ];
            return response()->json($res);
        }
    }

    function getUserByUsername($username)
    {
        $user = UserModel::UserDataByUsername($username);
        if ($user) {
            return response()->json($user);
        }
    }
    function getMyData($api) {
        $user = User::where('api_token', $api)->get();
        if ($user) {
            return response()->json($user);
        }
    }
    function searchUsers($ctr)
    {
        $dt = UserModel::SearchUsers(str_replace('%20', ' ', $ctr), 20);
        return response()->json($dt);
    }
}
