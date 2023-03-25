<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot', 'reset']]);
    }

    public function register(Request $request)
    {
        $input = $request->only('name', 'email', 'password', 'c_password');

        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->assignRole('admin');

        if($user){
            return response()->json([
                'message' => 'user registered successfully'
            ]);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'wrong credintials'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
    public function profileEdit(Request $request, User $user){
        $input = $request->only('email', 'password', 'c_password');

        $validator = $request->validate([
            'email' => 'email',
            'password' => 'min:8',
            'c_password' => 'same:password',
        ]);

        $input['password'] = bcrypt($input['password']);
        $update = $user->update($input);

        if($update){
            return response()->json([
                'message' => 'user updated successfully'
            ]);
        }
    }

    public function forgot(Request $request){
        $exist = $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        if($exist){
            $user = User::where('email', $request->email)->first();

            $token = Str::random(64);

            $insert = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            if($insert){
                Mail::send('email.reset', ['token'=> $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset your password');
                });

                return response()->json([
                    'success' => 'we have emailed you with reset password link'
                ]);
            }
        }else{
            return response()->json([
                'Error' => 'Something went wrong'
            ]);
        }
    }

    public function reset($token, Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $validateToken = DB::table('password_reset_tokens')->where([
            'token' => $token,
            'email' => $request->email
        ])->first();

        if(!$validateToken){
            return response()->json([
                'Error' => 'Invalid Token'
            ]);
        }

        $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

        if($user){
            DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

            return response()->json([
                'Success' => 'password updated successfully'
            ]);
        }
    }

}
