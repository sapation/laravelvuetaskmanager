<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $secretKey = "mDXspFOSAcCd/1htqFxcqyJXY1y0lwqCzek28RBgV18=";

    public function login(Request $request)
    {
        $fields = $request->all();
        $error = Validator::make($fields, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:8'
        ]);

        if ($error->fails()) {
            return response($error->errors()->all(), 422);
        }

        $user = User::where('email', $fields['email'])->first();
        if(!is_null($user)) {
            if(intval($user->isValidEmail) !== User::IS_VALID_EMAIL) {
                NewUserCreated::dispatch($user);
                return response([
                    'message' => 'We send you an email verification please check your email!',
                    'isLoggedIn' => false
                ], 422);
            }
        }

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message'=>'email or password invalid',
                'isLoggedIn' => false
            ], 422);
        }

        $token = $user->createToken($this->secretKey)->plainTextToken;
        return response([
            'user' => $user, 
            'message' => 'loggedin',
            'token' => $token,
            'isLoggedIn' => true
        ], 200);
    }

    public function register(Request $request)
    {
        $fields = $request->all();
        $error = Validator::make($fields, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:8'
        ]);

        if ($error->fails()) {
            return response($error->errors()->all(), 422);
        }

        $user = User::create([
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => $this->generateRandomCode(),
        ]);

        NewUserCreated::dispatch($user);

        return response(['user' => $user, 'message' => 'user created'], 200);
    }

    public function validEmail($token)
    {
        User::where('remember_token', $token)
            ->update(['isValidEmail' => User::IS_VALID_EMAIL]);

        return redirect('/app/login');
    }

    function generateRandomCode()
    {
        $code = Str::random(10) . time();
        return $code;
    }

    public function logoutUser(Request $request) {
        DB::table('personal_access_token')
        ->where('tokenable_id', $request->userId)
        ->delete();

        return response(['message'=> 'logout user'], 200);
    }
}
